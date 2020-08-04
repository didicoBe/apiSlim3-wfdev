<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './vendor/autoload.php';






/**
 * 
░█████╗░██████╗░░█████╗░░█████╗░███╗░░░███╗███████╗███╗░░██╗████████╗░█████╗░
██╔══██╗██╔══██╗██╔══██╗██╔══██╗████╗░████║██╔════╝████╗░██║╚══██╔══╝██╔══██╗
██║░░██║██████╔╝██║░░╚═╝███████║██╔████╔██║█████╗░░██╔██╗██║░░░██║░░░██║░░██║
██║░░██║██╔══██╗██║░░██╗██╔══██║██║╚██╔╝██║██╔══╝░░██║╚████║░░░██║░░░██║░░██║
╚█████╔╝██║░░██║╚█████╔╝██║░░██║██║░╚═╝░██║███████╗██║░╚███║░░░██║░░░╚█████╔╝
░╚════╝░╚═╝░░╚═╝░╚════╝░╚═╝░░╚═╝╚═╝░░░░░╚═╝╚══════╝╚═╝░░╚══╝░░░╚═╝░░░░╚════╝░
 */



 /**
 * Pega todos os orçamentos
 */
$app->get('/orcamento', function (Request $request, Response $response) use ($app) {
    
    $token = $request->getHeader("Authorization");

    $valida = validaToken($token[0]);
    
   
    
    if($valida){
       
       
            $sql='SELECT * FROM WF_orcamento';
            $db = getConnection();
            $stmt = $db->query($sql);
            $resultado = $stmt->fetchAll(PDO::FETCH_OBJ);
            

            //se nao encontrar nada return 400
            if(count($resultado) != 0){
                $vai = '[';
                foreach ($resultado as $value) {
                    $vai .= json_encode($value).',';
                }
                $vai = substr($vai,0,-1);
                $vai = $vai.']';
                return $response->write($vai)->withHeader('Content-type', 'application/json');
            }else{
                return $response->withJson(['response' => 'sem orcamento'],400)->withHeader('Content-type', 'application/json');
            }

            
    }else{
        return $response->withJson(['response' => 'erro token'],401)->withHeader('Content-type', 'application/json');  
    }
    
    
    
    
});



//verificar logado
$app->get('/orcamento/{id}', function (Request $request, Response $response) use ($app) {

    $token = $request->getHeader("Authorization");

    $valida = validaToken($token[0]);
    if($valida){
        $route = $request->getAttribute('route');
        $id = $route->getArgument('id');
        
        $sql='SELECT * FROM WF_orcamento WHERE id = '.$id.' ';
        $db = getConnection();
        $stmt = $db->query($sql);
        $resultado = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        
        if (count($resultado) != 0) {
            return $response->withJson($resultado,200)->withHeader('Content-type', 'application/json');
        }else{
            return $response->withJson(['response' => false],400)->withHeader('Content-type', 'application/json');
        }
    
        
        return $response->withJson(['response' => 'erro token'],401)->withHeader('Content-type', 'application/json');
    }

    
    
});


$app->put('/orcamento', function (Request $request, Response $response) use ($app) {
    
    $token = $request->getHeader("Authorization");

    $valida = validaToken($token[0]);
    
    //valores enviados pelo corpo
    $input = $request->getParsedBody();

  
    $id = $input['id'];
    
   
    
    if($valida){

        //valida se id existe na tabelas
        $sql="SELECT * FROM WF_orcamento WHERE id = '".$id."' ";
        $db = getConnection();
        $stmt = $db->query($sql);
        $busca = $stmt->fetchAll(PDO::FETCH_OBJ);
        

        if(count($busca) != 0){
           // $sql='UPDATE `User` set '.$senha.$codproduto.$email.$isbn.$nome.$tema.'  where id = "'.$id.'"';
            
            if($input['nome'] != "" || $input['nome'] != null ){
                $nome = "nome='". $input['nome']."'";
                $sql='UPDATE WF_orcamento set '.$nome.'  WHERE id = "'.$id.'"';
                $resultado = $db->prepare($sql)->execute();
            }

            if($input['telefone'] != "" || $input['telefone'] != null ){
                $telefone = "telefone='". $input['telefone']."'";
                $sql='UPDATE WF_orcamento set '.$telefone.'  WHERE id = "'.$id.'"';
                $resultado = $db->prepare($sql)->execute();
            }

            if($input['email'] != "" || $input['email'] != null ){
                $email = "email='". $input['email']."'";
                $sql='UPDATE WF_orcamento set '.$email.'  WHERE id = "'.$id.'"';
                $resultado = $db->prepare($sql)->execute();
            }

            if($input['tiposervico'] != "" || $input['tiposervico'] != null ){
                $tiposervico = "tiposervico='". $input['tiposervico']."'";
                $sql='UPDATE WF_orcamento set '.$tiposervico.'  WHERE id = "'.$id.'"';
                $resultado = $db->prepare($sql)->execute();
            }

            if($input['tipodev'] != "" || $input['tipodev'] != null ){
                $tipodev = "tipodev='". $input['tipodev']."'";
                $sql='UPDATE WF_orcamento set '.$tipodev.'  WHERE id = "'.$id.'"';
                $resultado = $db->prepare($sql)->execute();
            }

            if($input['prefctt'] != "" || $input['prefctt'] != null ){
                $prefctt = "prefctt='". $input['prefctt']."'";
                $sql='UPDATE WF_orcamento set '.$prefctt.'  WHERE id = "'.$id.'"';
                $resultado = $db->prepare($sql)->execute();
            }

            if($input['comonosconheceu'] != "" || $input['comonosconheceu'] != null ){
                $comonosconheceu = "comonosconheceu='". $input['comonosconheceu']."'";
                $sql='UPDATE WF_orcamento set '.$comonosconheceu.'  WHERE id = "'.$id.'"';
                $resultado = $db->prepare($sql)->execute();
            }
            
            
            return $response->withJson($input,200)->withHeader('Content-type', 'application/json');
        }else{
            return $response->withJson(['response' => 'id não localizado'],400)->withHeader('Content-type', 'application/json');
        }
        
    }






});







/**
 * 
███████╗██╗███╗░░░███╗  ░█████╗░██████╗░░█████╗░░█████╗░███╗░░░███╗███████╗███╗░░██╗████████╗░█████╗░
██╔════╝██║████╗░████║  ██╔══██╗██╔══██╗██╔══██╗██╔══██╗████╗░████║██╔════╝████╗░██║╚══██╔══╝██╔══██╗
█████╗░░██║██╔████╔██║  ██║░░██║██████╔╝██║░░╚═╝███████║██╔████╔██║█████╗░░██╔██╗██║░░░██║░░░██║░░██║
██╔══╝░░██║██║╚██╔╝██║  ██║░░██║██╔══██╗██║░░██╗██╔══██║██║╚██╔╝██║██╔══╝░░██║╚████║░░░██║░░░██║░░██║
██║░░░░░██║██║░╚═╝░██║  ╚█████╔╝██║░░██║╚█████╔╝██║░░██║██║░╚═╝░██║███████╗██║░╚███║░░░██║░░░╚█████╔╝
╚═╝░░░░░╚═╝╚═╝░░░░░╚═╝  ░╚════╝░╚═╝░░╚═╝░╚════╝░╚═╝░░╚═╝╚═╝░░░░░╚═╝╚══════╝╚═╝░░╚══╝░░░╚═╝░░░░╚════╝░
 */





