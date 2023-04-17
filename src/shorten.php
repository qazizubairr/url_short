<?php 
 namespace Zubair\UrlReduce;
   

function reduce_url($long_url){

   $dsn = 'mysql:host=localhost;dbname=url_shortener';
   $username = 'root';
   $password = '';
   $long_url = $long_url;
   $short_url = base_convert(uniqid(), 10, 36);
   $created_at = date("Y-m-d H:i:s");


   function short_url_unique_maker($dsn,$username,$password,$short_url){
        $pdo = new PDO($dsn, $username, $password);
        $stmt = $pdo->prepare("SELECT * FROM urls WHERE short_url = ?");
        $stmt->bindParam(1,$short_url);
        $stmt->execute();
        while ($stmt->rowCount() > 0) {
            $short_url = base_convert(uniqid(), 10, 36);
            $stmt->bindParam(1,$short_url);
            $stmt->execute();
        }
        return $short_url;
    }

    $short_url = short_url_unique_maker($dsn,$username,$password,$short_url);

    function Insertor($dsn,$username,$password,$long_url,$short_url,$created_at){
        $pdo = new PDO($dsn, $username, $password);
        $stmt = $pdo->prepare("INSERT INTO urls (long_url,short_url,created_at) VALUES (?,?,?) ");
        
        $stmt->bindParam(1,$long_url);
        $stmt->bindParam(2,$short_url);
        $stmt->bindParam(3,$created_at);
        $stmt->execute();
    }

    Insertor($dsn,$username,$password,$long_url,$short_url,$created_at);

    function short_url_retriever($dsn,$username,$password,$long_url){

        $pdo = new PDO($dsn, $username, $password);
        $stmt = $pdo->prepare("SELECT short_url FROM urls WHERE long_url = ?");
        if (isset($long_url)){
            $stmt->bindParam(1,$long_url);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $short_url = $row['short_url'];
            return $short_url;
        }else{
            echo "Error: long url not set";
            }

    }

    $retrieved_url = short_url_retriever($dsn,$username,$password,$long_url);

    return $retrieved_url;
}

    
    function all__info($dsn,$username,$password){
        $pdo = new PDO($dsn, $username, $password);
        $stmt = $pdo->prepare('SELECT * FROM urls');
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        print_r($data);
    }


    echo reduce_url('https://stackoverflow.com/questions/36429195/call-to-a-member-function-bind-param-on-null-while-update-query')


    

    

    

    
    
    

    
    
    
    // echo all__info($dsn,$username,$password);
  
    
    


    

?>