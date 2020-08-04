<?php


//conecta ao banco de dados
function getConnection() {
    $dbhost='localhost';
    $dbuser="wfb";
    $dbpass="w1b2n310";
    $dbname="wfdev";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
   }


function validaToken($token){
    
    if($token == "jW|SZmY52Exj6HJ") {
        return true;
    }else{
        return false;
    }
}



function enviaEmail($nomecompleto, $email, $Telefone, $tiposervico, $tipodev, $prefctt, $comonosconheceu){
    
    $data_envio = date('d/m/Y');
    $hora_envio = date('H:i:s');
    
    // Compo E-mail
    $arquivo = "
    <style type='text/css'>
    body {
    margin:0px;
    font-family:Verdane;
    font-size:12px;
    color: #666666;
    }
    a{
    color: #666666;
    text-decoration: none;
    }
    a:hover {
    color: #FF0000;
    text-decoration: none;
    }
    </style>
    <html>
        <table width='510' border='1' cellpadding='1' cellspacing='1' bgcolor='#CCCCCC'>
            <tr>
                <td>
                <tr>
                <td width='500'>Nome:$nomecompleto</td>
                </tr>
                <tr>
                    <td width='320'>E-mail:<b>$email</b></td>
                </tr>
                <tr>
                    <td width='320'>Telefone:<b>$Telefone</b></td>
                </tr>
                <tr>
                    <td width='320'>Telefone:<b>$tiposervico</b></td>
                </tr>
                <tr>
                    <td width='320'>Telefone:<b>$tipodev</b></td>
                </tr>
                <tr>
                    <td width='320'>Telefone:<b>$prefctt</b></td>
                </tr>
                <tr>
                <td width='320'>Telefone:<b>$comonosconheceu</b></td>
            </tr>
    
            </td>
            </tr>  
            <tr>
            <td>Este e-mail foi enviado em <b>$data_envio</b> às <b>$hora_envio</b></td>
            </tr>
        </table>
    </html>
    ";

    //enviar
   
    // emails para quem será enviado o formulário
    $emailenviar = "contato@wfdesenvolvimento.com.br";
    $destino = $emailenviar;
    $assunto = "Contato pelo Site";
    
    // É necessário indicar que o formato do e-mail é html
    $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: '.$nome.' <$email>';
    //$headers .= "Bcc: $EmailPadrao\r\n";
    
    $enviaremail = mail($destino, $assunto, $arquivo, $headers);
    if($enviaremail){
        $mgm = "E-MAIL ENVIADO COM SUCESSO! <br> O link será enviado para o e-mail fornecido no formulário";
        echo "enviado com sucesso";
    } else {
        $mgm = "ERRO AO ENVIAR E-MAIL!";
    echo "";
    }
}