<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './vendor/autoload.php';






/**
 * 
███████╗███╗░░██╗██╗░░░██╗██╗░█████╗░  ███████╗███╗░░░███╗░█████╗░██╗██╗░░░░░
██╔════╝████╗░██║██║░░░██║██║██╔══██╗  ██╔════╝████╗░████║██╔══██╗██║██║░░░░░
█████╗░░██╔██╗██║╚██╗░██╔╝██║███████║  █████╗░░██╔████╔██║███████║██║██║░░░░░
██╔══╝░░██║╚████║░╚████╔╝░██║██╔══██║  ██╔══╝░░██║╚██╔╝██║██╔══██║██║██║░░░░░
███████╗██║░╚███║░░╚██╔╝░░██║██║░░██║  ███████╗██║░╚═╝░██║██║░░██║██║███████╗
╚══════╝╚═╝░░╚══╝░░░╚═╝░░░╚═╝╚═╝░░╚═╝  ╚══════╝╚═╝░░░░░╚═╝╚═╝░░╚═╝╚═╝╚══════╝
 */



 /**
 * Cadastra um novo usuario
 */
$app->post('/email', function (Request $request, Response $response) use ($app) {
    
    $token = $request->getHeader("Authorization");

    $valida = validaToken($token[0]);
    
    //valores enviados pelo corpo
    $input = $request->getParsedBody();
    $nome = $input["nome"];
    $telefone = $input["telefone"];
    $email = $input["email"];
    $tiposervico = $input["tiposervico"];
    $tipodev = $input["tipodev"];
    $prefctt = $input["prefctt"];
    $comonosconheceu = $input["comonosconheceu"];
    
    
    if($valida){
        
        if($nome == ""){
            return $response->withJson(['response' => 'nome vazio'],400)->withHeader('Content-type', 'application/json');
        }elseif ($telefone == "") {
            return $response->withJson(['response' => 'telefone vazio'],400)->withHeader('Content-type', 'application/json');
        }elseif ($email == "") {
            return $response->withJson(['response' => 'email vazio'],400)->withHeader('Content-type', 'application/json');
        }elseif ($tiposervico == "Tipo de serviço* ") {
            return $response->withJson(['response' => 'tiposervico vazio'],400)->withHeader('Content-type', 'application/json');
        }elseif ($tipodev == "") {
            return $response->withJson(['response' => 'tipodev vazio'],400)->withHeader('Content-type', 'application/json');
        }elseif ($prefctt == "") {
            return $response->withJson(['response' => 'prefctt vazio'],400)->withHeader('Content-type', 'application/json');
        }elseif ($comonosconheceu == "") {
            return $response->withJson(['response' => 'comonosconheceu vazio'],400)->withHeader('Content-type', 'application/json');
        }else{


            //valida se email existe na tabelas
            $db = getConnection();
                    
            $sql='INSERT INTO `WF_orcamento` (`nome`, `telefone`, `email`, `tiposervico`, `tipodev`, `prefctt`, `comonosconheceu`) VALUES ("'.$nome.'", "'.$telefone.'", "'.$email.'", "'.$tiposervico.'", "'.$tipodev.'", "'.$prefctt.'", "'.$comonosconheceu.'");';


            try {
                $resultado = $db->prepare($sql)->execute();
                $db = null;
                // envia email
                enviaEmail($nome, $email, $telefone, $tiposervico, $tipodev, $prefctt, $comonosconheceu);



            return $response->withJson(['response' => 'salvo com sucesso' ],200)->withHeader('Content-type', 'application/json');    
            } catch (\Throwable $th) {

                return $response->withJson(['response' => 'erro ao enviar email'],400)->withHeader('Content-type', 'application/json');  
            }




        }





        
        
        
        



    }else{
        return $response->withJson(['response' => 'erro token'],401)->withHeader('Content-type', 'application/json');  
    }
    
    
    
    
});



/**
 * 
███████╗██╗███╗░░░███╗  ███████╗███╗░░██╗██╗░░░██╗██╗░█████╗░  ███████╗███╗░░░███╗░█████╗░██╗██╗░░░░░
██╔════╝██║████╗░████║  ██╔════╝████╗░██║██║░░░██║██║██╔══██╗  ██╔════╝████╗░████║██╔══██╗██║██║░░░░░
█████╗░░██║██╔████╔██║  █████╗░░██╔██╗██║╚██╗░██╔╝██║███████║  █████╗░░██╔████╔██║███████║██║██║░░░░░
██╔══╝░░██║██║╚██╔╝██║  ██╔══╝░░██║╚████║░╚████╔╝░██║██╔══██║  ██╔══╝░░██║╚██╔╝██║██╔══██║██║██║░░░░░
██║░░░░░██║██║░╚═╝░██║  ███████╗██║░╚███║░░╚██╔╝░░██║██║░░██║  ███████╗██║░╚═╝░██║██║░░██║██║███████╗
╚═╝░░░░░╚═╝╚═╝░░░░░╚═╝  ╚══════╝╚═╝░░╚══╝░░░╚═╝░░░╚═╝╚═╝░░╚═╝  ╚══════╝╚═╝░░░░░╚═╝╚═╝░░╚═╝╚═╝╚══════╝
 */





