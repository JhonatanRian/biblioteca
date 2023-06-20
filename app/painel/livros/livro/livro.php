<?php
$classBook = $livro["corcapa"];
$fonte = $livro["fonte"];
echo "<div class='book $classBook $fonte m-auto'>";
echo "<div class='d-flex p-1 align-items-center justify-content-center h-50'>";
echo "<span class='text-center'>";
echo $livro["nomelivro"];
echo "</span>";
echo "</div>";
echo "<div class='h-50 position-relative'>";
echo "<div class='position-absolute bottom-0 end-0 mb-2 me-2 subtitle'>";
echo $livro["nomeautor"];
echo "</div>";
echo "</div>";
echo "</div>";
?>