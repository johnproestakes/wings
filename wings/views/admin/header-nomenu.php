<!DOCTYPE html>
<html>
<head>
  <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <title><?=tpl_var('pageTitle', $data)?></title>
  <link type="text/css" rel="stylesheet" href="<?=wings_assets_dir('wings/')?>/bower_components/semantic/dist/semantic.min.css" />
  <link type="text/css" rel="stylesheet" href="<?=wings_assets_dir('wings/')?>/css/style.css" />

  <style type="text/css">
      body {
        background-color: #fafafa;
      }



    </style>
    <?php if(isset($scripts)): ?>
      <?php foreach($scripts as $script): ?>
        <script src="<?=$script?>" type="text/javascript"></script>
      <?php endforeach; ?>
    <?php endif; ?>

</head>
<body>

  <div class="ui top fixed menu">
    <div class="ui container">
  <a href="<?=link_to('/admin')?>" class="item">
    <i class="plane icon"></i> Wings
  </a>
  <a href="<?=link_to('/')?>" class="item">
    <i class="external icon"></i> <?=$app_name?>
  </a>
  <div class="right menu">
    <div class="ui dropdown link item">
    &nbsp;&nbsp;<i class="user large icon"></i>
    <i class="dropdown icon"></i>
    <div class="menu">
      <a href="<?=link_to('/admin/users')?>" class="item">My profile</a>
      <a href="<?=link_to('/admin/users')?>" class="item">Manage users</a>
      <a href="<?=link_to('/admin/logout')?>" class="item">Log out</a>
      </div></div>

    <a class="item" href="<?=link_to('/admin/settings')?>">
      &nbsp;<i class="settings large icon"></i>
    </a>
    </div>
  </div>
</div>

<div style="height: 75px;"></div>
<div class="ui container">
<div class="ui small breadcrumb">
  <a href="<?=link_to('/admin')?>" class="section">Home</a>
  <i class="right chevron icon divider"></i>
  <span class="section"><?=$pageTitle?></span></div><br><br>
</div>
</div>
<div class="ui container grid">

<div class="column">
  <h1><?=isset($pageTitle) ? $pageTitle : "Dashboard"?></h1>
