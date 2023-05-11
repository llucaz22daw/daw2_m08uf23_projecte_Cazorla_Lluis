<?php
require 'vendor/autoload.php';
use Laminas\Ldap\Attribute;
use Laminas\Ldap\Ldap;

ini_set('display_errors', 0);
#Dades de la nova entrada
#
if ($_POST['uid']){
    $uid=$_POST['uid'];
    $unorg=$_POST['ou'];
    $num_id=$_POST['uidNumber'];
    $grup=$_POST['gidNumber'];
    $dir_pers=$_POST['homeDirectory'];
    $sh=$_POST['loginShell'];
    $cn=$_POST['cn'];
    $sn=$_POST['sn'];
    $nom=$_POST['givenName'];
    $adressa=$_POST['postalAddress'];
    $mobil=$_POST['mobile'];
    $telefon=$_POST['telephoneNumber'];
    $titol=$_POST['title'];
    $descripcio=$_POST['description'];
    $objcl=array('inetOrgPerson','organizationalPerson','person','posixAccount','shadowAccount','top');
    #
    #Afegint la nova entrada
    $domini = 'dc=fjeclot,dc=net';
    $opcions = [
        'host' => 'zend-llcaco.fjeclot.net',
        'username' => "cn=admin,$domini",
        'password' => 'fjeclot',
        'bindRequiresDn' => true,
        'accountDomainName' => 'fjeclot.net',
        'baseDn' => 'dc=fjeclot,dc=net',
    ];
    $ldap = new Ldap($opcions);
    $ldap->bind();
    $nova_entrada = [];
    Attribute::setAttribute($nova_entrada, 'objectClass', $objcl);
    Attribute::setAttribute($nova_entrada, 'uid', $uid);
    Attribute::setAttribute($nova_entrada, 'uidNumber', $num_id);
    Attribute::setAttribute($nova_entrada, 'gidNumber', $grup);
    Attribute::setAttribute($nova_entrada, 'homeDirectory', $dir_pers);
    Attribute::setAttribute($nova_entrada, 'loginShell', $sh);
    Attribute::setAttribute($nova_entrada, 'cn', $cn);
    Attribute::setAttribute($nova_entrada, 'sn', $sn);
    Attribute::setAttribute($nova_entrada, 'givenName', $nom);
    Attribute::setAttribute($nova_entrada, 'mobile', $mobil);
    Attribute::setAttribute($nova_entrada, 'postalAddress', $adressa);
    Attribute::setAttribute($nova_entrada, 'telephoneNumber', $telefon);
    Attribute::setAttribute($nova_entrada, 'title', $titol);
    Attribute::setAttribute($nova_entrada, 'description', $descripcio);
    $dn = 'uid='.$uid.',ou='.$unorg.',dc=fjeclot,dc=net';
    if($ldap->add($dn, $nova_entrada)) echo "Usuari creat";
}
?>
<html>
    <head>
        <title>
        	AFEGINT DADES D'USUARIS DE LA BASE DE DADES LDAP
        </title>
    </head>
    <body>
        <h2>Formulari d'afegir un usuari</h2>
            <form action="http://zend-llcaco.fjeclot.net/zendldap2/afegirUsuaris.php" method="POST">
            User ID: <input type="text" name="uid" required><br>
            Unitat organitzativa: <input type="text" name="ou" required><br>
            User ID Number: <input type="number" name="uidNumber" required><br>
            Grup ID Number: <input type="number" name="gidNumber" required><br>
            Home Directory: <input type="text" name="homeDirectory" required><br>
            Login Shell: <input type="text" name="loginShell" required><br>
            CN: <input type="text" name="cn" required><br>
            SN: <input type="text" name="sn" required><br>
            Given Name: <input type="text" name="givenName" required><br>
            Mòbil: <input type="text" name="mobile" required><br>
            Adreça Postal: <input type="text" name="postalAddress" required><br>
            Telefon Mobil: <input type="text" name="telephoneNumber" required><br>
            Titol: <input type="text" name="title" required><br>
            Descripció: <input type="text" name="description" required><br>
            <input type="submit"/>
            <input type="reset"/><br>
            </form>
            <a href="http://zend-llcaco.fjeclot.net/autent/menu.php">Torna a la pàgina inicial</a>
    </body>
</html>