<? $this->AdminNav->setTitle( __d( 'admin', 'Usuarios'), __d( 'admin', 'Listado'), 'user') ?>


<div class="col-xs-12">
  <div class="table-responsive">
	<table id="" class="table table-striped table-bordered table-hover dataTable" aria-describedby="">
	  <thead>
  	  <tr>
        <th class="sorting_asc header" role="columnheader" tabindex="0" aria-controls="" aria-sort="ascending"><?= $this->Paginator->sort('id', 'Id');?></th>
        <th class="hidden-480 sorting header" role="columnheader" aria-controls=""><?= $this->Paginator->sort('name', __d( 'admin', 'Nombre'));?></th>
        <th class="hidden-480 sorting header" role="columnheader" aria-controls=""><?= $this->Paginator->sort('email', __d( 'admin', 'Email'));?></th>
        <th class="header"><?= __('Actions') ?></th>
    	</tr>
  	</thead>
  	<? foreach ($users as $user): ?>
  	  <tbody>
    	  <tr>
      		<td><?= $user['User']['id'] ?>&nbsp;</td>
      		<td><?= $this->Html->link( $user['User']['name'], array(
  			      'action' => 'edit',
  			      $user ['User']['id']
  			  )) ?>&nbsp;</td>
      		<td><?= $user['User']['email'] ?>&nbsp;</td>
      		<td class="">
      		  <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
							<?= $this->Html->link( '<i class="icon-pencil bigger-120"></i>', array(
      			      'action' => 'edit',
      			      $user ['User']['id']
      			  ), array(
      			      'class' => 'btn btn-xs btn-success',
      			      'escape' => false
      			  )) ?>
      			  
      			  <?= $this->Html->link( '<i class="icon-trash bigger-120"></i>', array(
      			      'action' => 'delete',
      			      $user ['User']['id']
      			  ), array(
      			      'class' => 'btn btn-xs btn-danger',
      			      'escape' => false
      			  ), __d( 'admin', "¿Estás seguro de que quieres borrarlo?")) ?>
						</div>
      		</td>
      	</tr>
    	</tbody>
    <? endforeach ?>
	</table>
	</div>
	<?= $this->element( 'pagination');?>
</div>