<?php $this->layout('layout')

hello test ! je suis un fichier de vue !
<br/>
<a href="<?php echo $this->url('default_home'); ?>" title="Retour à l'accueil">Revenir à l'accueil </a>
<br/>
<?= $contenu ?>