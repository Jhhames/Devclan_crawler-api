<?php

namespace App\Http\Controllers;

use Goutte\Client as GoutteClient;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use Symfony\Component\CssSelector\CssSelectorConverter;

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
        $title_array = array();

        $client->setClient($guz);

        try{
            $crawler  = $client->request('GET','http://www.ft.com/rss/companies/aerospace-defence?isFeed=true');
            $title = $crawler->filter('item > title')
                ->each(
                    function ($node) {
                    // print $node->text()."\n";
                    array_push($title_array, $node->text());
                }
            );
            
        }
        catch(ConnectException $e){
            $errorMessage= $e->getMessage();
        }
        catch(\Exception $e){
            $errorMessage = $e->getMessage();
        }

        if(isset($errorMessage)){
            echo $errorMessage;

        }else{ 
            return $title_array;
        }

    }
    //
}
