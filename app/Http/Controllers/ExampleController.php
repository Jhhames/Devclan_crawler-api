<?php

namespace App\Http\Controllers;

use Goutte\Client as GoutteClient;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use Symfony\Component\CssSelector\CssSelectorConverter;
use App\NewsModel as News;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function example(){
        $test = new GuzzleClient([
            'base_uri' => 'https://jsonplaceholder.typicode.com',
            'timeout' => 20
        ]);
        
        // $request = new Request('GET','/posts');
        
        try{
           $response = $test->request('GET', 'posts');
           $body = $response->getBody();
           $statusCode = $response->getStatusCode();
           $statusMessage = $response->getReasonPhrase();
        }catch(ConnectException $e){
                $error = $e->getMessage();
        }

        if(isset($statusCode) && $statusCode == '200'):
            $body = json_decode($body);
            foreach ($body as $row ) {
                    echo '<h3>'. $row->title.'</h3>' . '<br>';
                    echo '<p>'. $row->body .'</p><br>';
                }
        else:
            echo $error;
        endif;
        
    
    }

    public function crawlEg(){ 
        $client = new GoutteClient();
        $guz = new GuzzleClient([
            'timeout'=> 20
        ]);
        $client->setClient($guz);
        $title_array = array();
        $description_array = array();
        $link_array = array();
        $author_array = array();
        $date_array = array();
        $content_array = array();
        $status = array();
        
        try{
            $crawler  = $client->request('GET','https://www.theguardian.com/uk/environment/rss');
            $title = $crawler->filter('item > title');
            $description = $crawler->filter('item > description');
            $link = $crawler->filter('item > link');
            // $author = $crawler->filter('item > dc');
            $date = $crawler->filter('item > pubDate');

        }
        catch(ConnectException $e){
            $errorMessage= $e->getMessage();
            $errorLine = $e->getLine();
            $errorFile = $e->getFile();
        }
        catch(\Exception $e){
            $errorMessage = $e->getMessage();
            $errorLine = $e->getLine();
            $errorFile = $e->getFile();
        }
        
        if(isset($errorMessage)){
            echo '<b>'.$errorMessage.'</b> check '.$errorFile.' on '.$errorLine;
            
        }else{ 
            foreach($title as $row){
                array_push($title_array, $row->nodeValue);
            }
            foreach($description as $row){
                array_push($description_array, strip_tags($row->nodeValue));
            }
            foreach($link as $row){
               $linkName = $row->nodeValue;
               $linkCrawl = $client->request('GET', $linkName);
               $content = $linkCrawl->filter('div.content__article-body');
               array_push($content_array,$content->text);

            }
            // foreach($author as $row){
            //     array_push($author_array, $row);
            // }
            foreach($date as $row){
                array_push($date_array, $row->nodeValue);
            }

            // print_r($title_array);
            // print_r($date_array);
            print_r($content_array);
             
            for ($i=0; $i <= count($description_array) - 1 ; $i++) { 
                $news = new News;
                $news->title = $title_array[$i];
                $news->description = $description_array[$i];
                $news->link = $link_array[$i];
                // $news->author = $author_array[$i];
                $news->date = $date_array[$i];

                // if($news->save()){   
                //     $status[$i] = 'true';
                // }
                // else{
                //     $status[$i] = 'false';
                // }
                    
            }
        }
        
    }

}
