<div class="col-xs-12">
  <div class="table-responsive">
	<table id="" class="table table-striped table-bordered table-hover dataTable" aria-describedby="">
	  <thead>
  	  <tr>
        <th class="sorting_asc header" role="columnheader" tabindex="0" aria-controls="" aria-sort="ascending"><?= $this->Paginator->sort('id', 'Id');?></th>
        <th class="hidden-480 sorting header" role="columnheader" aria-controls=""><?= $this->Paginator->sort('name');?></th>
        <th class="hidden-480 sorting header" role="columnheader" aria-controls=""><?= $this->Paginator->sort('created');?></th>
        <th class="hidden-480 sorting header" role="columnheader" aria-controls=""><i class="icon-time bigger-110 hidden-480"></i><?= $this->Paginator->sort('modified');?></th>
        <th class="header"><?= __('Actions') ?></th>
    	</tr>
  	</thead>
  	<? foreach ($groups as $group): ?>
  	  <tbody>
    	  <tr>
      		<td><?= h($group['Group']['id']); ?>&nbsp;</td>
      		<td><?= h($group['Group']['name']); ?>&nbsp;</td>
      		<td><?= h($group['Group']['created']); ?>&nbsp;</td>
      		<td><?= h($group['Group']['modified']); ?>&nbsp;</td>
      		<td class="">
      		  <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
							<?= $this->Html->link( '<i class="icon-pencil bigger-130"></i>', array(
      			      'action' => 'edit',
      			      $group ['Group']['id']
      			  ), array(
      			      'class' => 'btn btn-xs btn-success',
      			      'escape' => false
      			  )) ?>
      			  
      			  <?= $this->Html->link( '<i class="icon-trash bigger-130"></i>', array(
      			      'action' => 'delete',
      			      $group ['Group']['id']
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