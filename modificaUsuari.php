<?php
require 'vendor/autoload.php';
use Laminas\Ldap\Attribute;
use Laminas\Ldap\Ldap;

ini_set('display_errors', 0);
#
# Entrada a modificar
#
if (isset($_POST['boto'])){
    $atribut=$_POST['atributs']; # El número identificador d'usuar té el nom d'atribut uidNumber
    $nou_contingut=$_POST['value'];
    if($atribut == 'gidNumber' || $atribut ==  'uidNumber'){
        $nou_contingut = intval($nou_contingut);
    }
    $uid = $_POST['uid'];
    $unorg = $_POST['ou'];
    $dn = 'uid='.$uid.',ou='.$unorg.',dc=fjeclot,dc=net';
    #
    #Opcions de la connexió al servidor i base de dades LDAP
    $opcions = [
        'host' => 'zend-llcaco.fjeclot.net',
        'username' => 'cn=admin,dc=fjeclot,dc=net',
        'password' => 'fjeclot',
        'bindRequiresDn' => true,
        'accountDomainName' => 'fjeclot.net',
        'baseDn' => 'dc=fjeclot,dc=net',
    ];
    #
    # Modificant l'entrada
    #
    $ldap = new Ldap($opcions);
    $ldap->bind();
    $entrada = $ldap->getEntry($dn);
    if ($entrada){
        Attribute::setAttribute($entrada,$atribut,$nou_contingut);
        $ldap->update($dn, $entrada);
        echo "Atribut modificat";
    } else echo "<b>Aquesta entrada no existeix</b><br><br>";
}
?>
<html>
    <head>
        <title>
        	MODIFICANT DADES D'USUARIS DE LA BASE DE DADES LDAP
        </title>
    </head>
    <body>
        <h2>Formulari de selecció d'usuari</h2>
            <form action="http://zend-llcaco.fjeclot.net/zendldap3/modificaUsuari.php" method="POST">
            User ID: <input type="text" name="uid" required><br>
            Unitat organitzativa: <input type="text" name="ou" required><br>
            <label>Selecciona l'atribut que vols modificar:</label><br>
			<input type="radio" name="atributs" value="uidNumber"/><label>uidNUmber</label><br>
			<input type="radio" name="atributs" value="gidNumber"/><label>gidNUmber</label><br>
			<input type="radio" name="atributs" value="homeDirectory"/><label>Directori Personal</label><br>
			<input type="radio" name="atributs" value="loginShell"/><label>Shell</label><br>
			<input type="radio" name="atributs" value="cn"/><label>cn</label><br>
			<input type="radio" name="atributs" value="sn"/><label>sn</label><br>
			<input type="radio" name="atributs" value="givenName"/><label>givenName</label><br>
			<input type="radio" name="atributs" value="postalAddress"/><label>postalAddress</label><br>
			<input type="radio" name="atributs" value="mobile"/><label>mobile</label><br>
			<input type="radio" name="atributs" value="telephoneNumber"/><label>telephoneNumber</label><br>
			<input type="radio" name="atributs" value="title"/><label>title</label><br>
			<input type="radio" name="atributs" value="description"/><label>description</label><br>
			<label>Inserta el nou valor:</label><br>
			<input type="text" name="value"/><br>
            <input type="submit" name="boto"/>
            <input type="reset"/><br>
            <a href="http://zend-llcaco.fjeclot.net/autent/menu.php">Torna a la pàgina inicial</a>
        </form>
    </body>
</html>