<?
  $has_password_errors = false;
  
  $fields = array( 'password', 'password_current', 'password2');
  
  foreach( $fields as $field)
  {
    if( array_key_exists( $field, $this->validationErrors ['User']))
    {
      $has_password_errors = true;
    }
  }
?>

<? $this->AdminNav->setTitle( __d( 'admin', 'Usuarios'), __d( 'admin', 'Edición'), 'user') ?>

<div class="groups form">

<?= $this->Form->create( 'User', array(
    'class' => 'form-horizontal'
)) ?>
  
  <?= $this->Form->hidden( 'User.id') ?>
  
  <?= $this->Form->input( 'User.name', array(
      'type' => 'text',
      'label' => 'Nombre'
  )) ?>

  <?= $this->Form->input( 'User.email', array(
      'type' => 'text',
      'label' => 'Email'
  )) ?>
  
  <?= $this->Form->input( 'User.group_id', array(
      'type' => 'select',
      'label' => 'Grupo'
  )) ?>
  
  <?= $this->Form->input( 'User.status', array(
      'type' => 'checkbox',
      'label' => 'Activo',
      'class' => 'ace'
  )) ?>
  
  <h5 class="header smaller lighter green"><i class="icon-lock"></i> <span class="pointer" id="btn-change-password"><?= __d( 'admin', "Cambiar contraseña") ?></span></h5>
    <div id="div-change-password" class="<?= !$has_password_errors ? "hidden" : '' ?>">
    <?= $this->Form->input( 'User.password_current', array(
        'label' => __d( 'admin', "Contraseña actual"),
        'type' => 'password',
        'required' => false
    )) ?>
  
    <?= $this->Form->input( 'User.password', array(
        'label' => __d( 'admin', "Nueva contraseña"),
        'required' => false
    )) ?>
    
    <?= $this->Form->input( 'User.password2', array(
        'type' => 'password',
        'label' => __d( 'admin', "Repite la contraseña"),
        'required' => false
    )) ?>
  </div>
  
  <? $this->append( 'scripts') ?>
    <script type="text/javascript">
      $(function(){
        $("#btn-change-password").click(function(){
          $("#div-change-password").toggle().removeClass( 'hidden');
        })
      })
    </script>
  <? $this->end() ?>
	<?= $this->Form->submit( __d( 'admin', 'Guardar')) ?>
<?= $this->Form->end();?>
</div>