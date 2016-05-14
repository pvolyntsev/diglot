<h1>Файлы для Diglot</h1>
<?php foreach ($files as $file) { ?>
	<h2><?=$file['name']?></h2>
	<textarea name="" id="" cols="100" rows="10"><?=base64_decode($file['content'])?></textarea>
	<hr>
<?php } ?>
