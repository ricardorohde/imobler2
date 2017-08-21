<?php
function print_l($_array = null){
  if($_array){
    echo '<pre>' . print_r($_array, true) . '</pre>';
  }
}
require ('meekrodb.2.3.class.php');
$antigo = new MeekroDB('localhost', 'root', 'adm5135', 'medizdepara', '3306', 'utf8');
$novo = new MeekroDB('localhost', 'root', 'adm5135', 'mediz_imobler', '3306', 'utf8');

$campanhas = $antigo->query("
  SELECT
    *
  FROM
    campanhas
");

foreach ($campanhas as $campanha) {
  $array = array(
    'categoria' => 1,
    'permalink' => $campanha['slug'],
    'titulo' => $campanha['nome'],
    'descricao' => $campanha['descricao']
  );

  $novo->insert('campanhas', $array);
}
?>


