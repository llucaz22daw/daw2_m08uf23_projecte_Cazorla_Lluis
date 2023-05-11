<?php
require 'vendor/autoload.php';
use Laminas\Ldap\Ldap;

ini_set('display_errors', 0);
#
# Entrada a esborrar: usuari 3 creat amb el projecte zendldap2
#
if ($_POST['uid']){
    $uid = $_POST['uid'];
    $unorg = $_POST['ou'];
    $dn = 'uid='.$uid.',ou='.$unorg.',dc=fjeclot,dc=net';
    #
    #Opcions de la connexió al servidor i base de dades LDAP
    $domini = 'dc=fjeclot,dc=net';
    $opcions = [
        'host' => 'zend-llcaco.fjeclot.net',
        'username' => "cn=admin,$domini",
        'password' => 'fjeclot',
        'bindRequiresDn' => true,
        'accountDomainName' => 'fjeclot.net',
        'baseDn' => 'dc=fjeclot,dc=net',
    ];
    
    #
    # Esborrant l'entrada
    #
    $ldap = new Ldap($opcions);
    $ldap->bind();
    try{
        $ldap->delete($dn);
        echo "<b>Entrada esborrada</b><br>";
    } catch (Exception $e){
        echo "<b>Aquesta entrada no existeix</b><br>";
    }
}
?>
<html>
    <head>
        <title>
        	ESBORRANT USUARIS DE LA BASE DE DADES LDAP
        </title>
    </head>
    <body>
        <h2>Formulari d'esborrament d'usuari</h2>
            <form action="http://zend-llcaco.fjeclot.net/zendldap4/esborraUsuari.php" method="POST">
            Unitat organitzativa: <input type="text" name="ou"><br>
            User ID: <input type="text" name="uid"><br>
            <input type="submit"/>
            <input type="reset"/><br>
            </form>
            <a href="http://zend-llcaco.fjeclot.net/autent/menu.php">Torna a la pàgina inicial</a>
        
    </body>
</html>