<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './vendor/autoload.php';






/**
 * 
██╗░░░░░░█████╗░░██████╗░██╗███╗░░██╗
██║░░░░░██╔══██╗██╔════╝░██║████╗░██║
██║░░░░░██║░░██║██║░░██╗░██║██╔██╗██║
██║░░░░░██║░░██║██║░░╚██╗██║██║╚████║
███████╗╚█████╔╝╚██████╔╝██║██║░╚███║
╚══════╝░╚════╝░░╚═════╝░╚═╝╚═╝░░╚══╝
 */



 /**
 * login inicial
 */
$app->post('/login', function (Request $request, Response $response) use ($app) {
    
    $token = $request->getHeader("Authorization");

    $valida = validaToken($token[0]);
    
    //valores enviados pelo corpo
    $input = $request->getParsedBody();
    $login = $input["login"];
    $senha = $input["senha"];
    
   $token = '';
    
    if($valida){
       
        if($login == ""){
            return $response->withJson(['response' => 'login vazio'],400)->withHeader('Content-type', 'application/json');
        }elseif ($senha == "") {
            return $response->withJson(['response' => 'senha vazio'],400)->withHeader('Content-type', 'application/json');
        }else{
            $sql='SELECT * FROM WF_usuarios WHERE email = "'.$login.'" and senha = "'.$senha.'" ';
            

            $db = getConnection();
            $stmt = $db->query($sql);
            $resultado = $stmt->fetchAll(PDO::FETCH_OBJ);
           

            //se nao encontrar nada return 400
            if(count($resultado) != 0){
                $token = md5($email+$senha+rand());
                $sqlUpdateToken = 'UPDATE WF_usuarios SET token="'.$token.'" WHERE id = '.$resultado[0]->id.'';
                $db->prepare($sqlUpdateToken)->execute();

                $stmt2 = $db->query($sql);
                $resultado = $stmt2->fetchAll(PDO::FETCH_OBJ);
                $db = null;

                return $response->withJson(['response' => $resultado],200)->withHeader('Content-type', 'application/json');
            }else{
                return $response->withJson(['response' => 'usuario nao localizado'],400)->withHeader('Content-type', 'application/json');
            }

            //se nao
            
            
            
           



        }





        
        
        
        



    }else{
        return $response->withJson(['response' => 'erro token'],401)->withHeader('Content-type', 'application/json');  
    }
    
    
    
    
});



//verificar logado
$app->get('/login/{email}/{token}', function (Request $request, Response $response) use ($app) {

    $token = $request->getHeader("Authorization");

    $valida = validaToken($token[0]);
    if($valida){
        $route = $request->getAttribute('route');
        $email = $route->getArgument('email');
        $token = $route->getArgument('token');
        
        $sql='SELECT * FROM WF_usuarios WHERE email = "'.$email.'" and token = "'.$token.'" ';
        $db = getConnection();
        $stmt = $db->query($sql);
        $resultado = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        
        if (count($resultado) != 0) {
            return $response->withJson(['response' => true],200)->withHeader('Content-type', 'application/json');
        }else{
            return $response->withJson(['response' => false],400)->withHeader('Content-type', 'application/json');
        }
    
        
        return $response->withJson(['response' => 'erro token'],401)->withHeader('Content-type', 'application/json');
    }

    
    
});





//sair
$app->get('/logout/{email}/{token}', function (Request $request, Response $response) use ($app) {

    $token = $request->getHeader("Authorization");

    $valida = validaToken($token[0]);
    if($valida){
        $route = $request->getAttribute('route');
        $email = $route->getArgument('email');
        $token = $route->getArgument('token');
        
        $sql='UPDATE WF_usuarios SET token="" WHERE email = "'.$email.'" and token = "'.$token.'" ';
        $db = getConnection();
        $resultado = $db->prepare($sql)->execute();
        $db = null;

        
        if (count($resultado) != 0) {
            return $response->withJson(['response' => true],200)->withHeader('Content-type', 'application/json');
        }else{
            return $response->withJson(['response' => false],400)->withHeader('Content-type', 'application/json');
        }
    
        
        return $response->withJson(['response' => 'erro token'],401)->withHeader('Content-type', 'application/json');
    }

    
    
});



/**
 * 
███████╗██╗███╗░░░███╗  ██╗░░░░░░█████╗░░██████╗░██╗███╗░░██╗
██╔════╝██║████╗░████║  ██║░░░░░██╔══██╗██╔════╝░██║████╗░██║
█████╗░░██║██╔████╔██║  ██║░░░░░██║░░██║██║░░██╗░██║██╔██╗██║
██╔══╝░░██║██║╚██╔╝██║  ██║░░░░░██║░░██║██║░░╚██╗██║██║╚████║
██║░░░░░██║██║░╚═╝░██║  ███████╗╚█████╔╝╚██████╔╝██║██║░╚███║
╚═╝░░░░░╚═╝╚═╝░░░░░╚═╝  ╚══════╝░╚════╝░░╚═════╝░╚═╝╚═╝░░╚══╝
 */





