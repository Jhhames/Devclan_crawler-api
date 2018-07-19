<?php

namespace App\Http\Controllers;

use Goutte\Client as GoutteClient;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;

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
            'timeout' => 2
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
    
        // $response = $test->send($request,['timeout'=>2] );
        // if(isset($body)):
        // $response = $request->getBody();
        // return $response;
        // $body = json_decode($body);    
         
            // if($statusCode == '200'):
                // foreach ($response as $row ) {
                    // echo '<h3>'. $row->title.'</h3>' . '<br>';
                    // echo '<p>'. $row->body .'</p><br>';
                // }
            // else:
                // echo $error;
            // endif;
        // else:
            // echo $error;
        // endif;
       
        
    
    }

    public function crawlEg(){
        $client = new GoutteClient();
        $guz = new GuzzleClient([
            'timeout'=> 20
        ]);

        $client->setClient($guz);

        try{
            $crawler  = $client->request('GET','https://symfony.com/blog/category/security-advisories/');
            $crawled = $crawler->filter('a');
            // ->each(
            //     function ($node) {
            //     print $node->text()."\n";
            // }
        // );
            
        }
        catch(ConnectException $e){
            $errorMessage= $e->getMessage();
        }

        if(isset($errorMessage)){
            echo $errorMessage;
        }else{
            print_r($crawled->text());
        }

    }
    //
}
