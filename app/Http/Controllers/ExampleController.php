<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request as FormRequest;
use Goutte\Client as GoutteClient;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use Symfony\Component\CssSelector\CssSelectorConverter;
use App\NewsModel as News;
use App\PreNewsModel as PreNews;

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

    public function crawlEg(FormRequest $request){ 
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
            
        $crawl_url = $request->get('cat');
        $urlArray = parse_url($crawl_url);
        $path = $urlArray['path'];
        $exp = explode('/', $path);
        if(count($exp) == 4){
            $newsCategory = $exp[2];
        }elseif(count($exp) == 3 ){
            $newsCategory = $exp[1];
        }
     
        
        try{
            $crawler  = $client->request('GET',$crawl_url);
            $title = $crawler->filter('item > title');
            $description = $crawler->filter('item > description');
            $link = $crawler->filter('item > link');
            // $author = $crawler->filter('item > dc');
            // $date = $crawler->filter('item > pubDate');

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
                array_push($link_array, $row->nodeValue);     
                // $linkName = $row->nodeValue;
                // $linkCrawl = $client->request('GET', $linkName);
                // $content = $linkCrawl->filter('div.content__article-body');
                // array_push($content_array,$content->text);

            }
            // foreach($author as $row){
            //     array_push($author_array, $row);
            // }
            // foreach($date as $row){
            //     array_push($date_array, $row->nodeValue);
            // }

            // print_r($title_array);
            // print_r($date_array);
            // print_r($content_array);
             
            for($i=0; $i <= count($description_array) - 1 ; $i++){ 
                    $news = new PreNews;
                    $news->title = $title_array[$i];
                    $news->description = $description_array[$i];
                    $news->link = $link_array[$i];
                    $news->category = $newsCategory;
                    // $news->author = $author_array[$i];
                    // $news->date = $date_array[$i];

                    if($news->save()){   
                        $status[$i] = 'true';
                    }
                    else{
                        $status[$i] = 'false';
                    }
                        
            }
            print_r($status);
        }
        
    }

    public function api(FormRequest $request, $category){
        if(!isset($category) || empty($category)){
            return response()->json(['error'=>'No category specified' ]);
        }else{
            try{
                $dbQuery = DB::table('prenews')->where('category', $category);
                if($dbQuery->exists()){
                    $dbValues = $dbQuery->get();
                }else{
                    $dbError ='Invalid Category';
                }
            }catch(\Exception $e){
                $dError = $e->getMessage();

            }catch(\ErrorException $e){
                $dError = $e->getMessage();
            }
            
            if(isset($dbError)){
                return response()->json(['error'=> $dbError]);;
            }else{
                return  response()->json($dbValues);
            }

        }      
    }

    public function urltest(FormRequest $request){
        $url = $request->get('cat');
        $urlArray = parse_url($url);
        $path = $urlArray['path'];
        $exp = explode('/', $path);
        if(count($exp) == 4){
            echo $exp[2];
        }elseif(count($exp) == 3 ){
            echo $exp[1];
        }
   

    }

}
