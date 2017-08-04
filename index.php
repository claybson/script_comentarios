<?php
try{
    $pdo = new PDO("mysql:dbname=blog;host=localhost", "root","123");
}catch(PDOException $e){
    echo "Erro: ".$e->getMessage();
    exit;
}
if(isset($_POST['nome']) && empty($_POST['nome']) == false){
    $nome = $_POST['nome'];
    $mensagem = $_POST['mensagem'];
    
    $sql = $pdo->prepare("INSERT INTO mensagens SET nome = :nome, mensagem = :mensagem, data_mens = NOW()");
    $sql->bindValue(":nome", $nome);
    $sql->bindValue(":mensagem", $mensagem);
    $sql->execute();
}
?>

<fieldset>
    <form method="POST">
        Nome:<br/>
        <input type="text" name="nome"/><br/><br/>
        
        Mensagem:<br/>
        <textarea name="mensagem"></textarea><br/><br/>
        
        <input type="submit" value="Enviar Mensagem">
    </form>
</fieldset>
<br/><br/>

<?php
$sql = "SELECT * FROM mensagens ORDER BY data_mens DESC";
$sql = $pdo->query($sql);
if($sql->rowCount() > 0){
    foreach ($sql->fetchAll() as $mensagem):
        ?>
        <strong><?php echo $mensagem['nome'];?></strong><br/>
        <?php echo $mensagem['mensagem'];?>
        <hr/>
        <?php
    endforeach;
}else{
    echo "Não há mensagens.";
}
?>
