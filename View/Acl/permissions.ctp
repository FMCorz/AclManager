<div class="form">
<h3><?php echo sprintf(__("%s permissions"), $aroAlias); ?></h3>

<div class="row">
	<div class="col-md-4">
		<?php echo $this->Form->create('Page', array('default' => false));?>
		<?php echo $this->Form->input('group_id', array('id' => 'AroSelector', 'div' => false, 'label' => 'Jump to...', 'options' => $aroList, 'empty' => $aroAlias, 'value' => isset($this->params['named']['page']) ? $this->params['named']['page'] -1 : ''));?>
		<?php echo $this->Form->end(null);?>
	</div>
	
	<div class="col-md-8">
		<?php echo $this->Paginator->pagination(array(
		     'modulus' => '4',
		     'first_title' => '«',
		     'last_title' => '»',
		     'prev_title' => '‹ prev',
		     'next_title' => 'next ›',
		     'ul' => 'pagination pagination-sm pull-right',
		));?>
		
		<p class="pagination pull-right text-right">
		     <?php echo $this->Paginator->counter(
		          '{:count} results, showing {:start} - {:end}'
		     );?> &nbsp;
		</p>
	</div>
</div>

<?php echo $this->Form->create('Perms'); ?>
<table class="aclmanager-permissions">
	<tr>
		<th>Action</th>
		<?php foreach ($aros as $aro): ?>
		<?php $aro = array_shift($aro); ?>
		<th><?php echo h($aro[$aroDisplayField]); ?></th>
		<?php endforeach; ?>
	</tr>
<?php
$uglyIdent = Configure::read('AclManager.uglyIdent'); 
$lastIdent = null;
foreach ($acos as $id => $aco) {
	$action = $aco['Action'];
	$alias = $aco['Aco']['alias'];
	$ident = substr_count($action, '/');
	if ($ident <= $lastIdent && !is_null($lastIdent)) {
		for ($i = 0; $i <= ($lastIdent - $ident); $i++) {
			?></tr><?php
		}
	}
	if ($ident != $lastIdent) {
		?><tr class='aclmanager-ident-<?php echo $ident; ?>'><?php
	}
	?><td><?php echo ($ident == 1 ? "<strong>" : "" ) . ($uglyIdent ? str_repeat("&nbsp;&nbsp;", $ident) : "") . h($alias) . ($ident == 1 ? "</strong>" : "" ); ?></td>
	<?php foreach ($aros as $aro): 
		$inherit = $this->Form->value("Perms." . str_replace("/", ":", $action) . ".{$aroAlias}:{$aro[$aroAlias]['id']}-inherit");
		$allowed = $this->Form->value("Perms." . str_replace("/", ":", $action) . ".{$aroAlias}:{$aro[$aroAlias]['id']}"); 
		$value = $inherit ? 'inherit' : null; 
		$icon = $this->Html->image(($allowed ? 'test-pass-icon.png' : 'test-fail-icon.png')); ?>
		<td>
			<?php echo $icon . " " . $this->Form->input("Perms." . str_replace("/", ":", $action) . ".{$aroAlias}:{$aro[$aroAlias]['id']}", array(
				'options' => array(
				     'inherit' => __('Inherit'),
				     'allow' => __('Allow'),
				     'deny' => __('Deny')
				),
				'empty' => __('No change'),
				'value' => $value,
				'div' => false,
				'label' => false,
				'wrapInput' => false,
				'class' => 'input-sm'
			)); ?>
		</td>
	<?php endforeach; ?>
<?php 
	$lastIdent = $ident;
}
for ($i = 0; $i <= $lastIdent; $i++) {
	?></tr><?php
}
?></table>
<?php
echo $this->Form->submit(__("Save"), array('class' => 'btn btn-primary'));
echo $this->Form->end(null);
?>

<?php echo $this->Paginator->pagination(array(
     'modulus' => '4',
     'first_title' => '«',
     'last_title' => '»',
     'prev_title' => '‹ prev',
     'next_title' => 'next ›',
     'ul' => 'pagination pagination-sm pull-right',
));?>

<p class="pagination pull-right text-right">
     <?php echo $this->Paginator->counter(
          '{:count} results, showing {:start} - {:end}'
     );?> &nbsp;
</p>

</div>
<div class="actions">
	<h3><?php echo __('Manage for'); ?></h3>
	<?php 
	$aroModels = Configure::read("AclManager.aros");
	if ($aroModels > 1): ?>
		<ul><?php foreach ($aroModels as $aroModel): ?>
			<li><?php echo $this->Html->link($aroModel, array('aro' => $aroModel)); ?></li>
		<?php endforeach; ?>
		</ul>
	<?php endif; ?>
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('< Back'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Manage permissions'), array('action' => 'permissions')); ?></li>
		<li><?php echo $this->Html->link(__('Update ACOs'), array('action' => 'update_acos')); ?></li>
		<li><?php echo $this->Html->link(__('Update AROs'), array('action' => 'update_aros')); ?></li>
		<li><?php echo $this->Html->link(__('Drop ACOs/AROs'), array('action' => 'drop'), array(), __("Do you want to drop all ACOs and AROs?")); ?></li>
		<li><?php echo $this->Html->link(__('Drop permissions'), array('action' => 'drop_perms'), array(), __("Do you want to drop all the permissions?")); ?></li>
	</ul>
</div>

<?php
	$params = array(
		'prefix' => $this->params['prefix'],
		'plugin' => $this->params['plugin'],
		'controller' => $this->params['controller'],
		'action' => $this->params['action']
	);
?>

<script type="text/javascript">
//<![CDATA[
jQuery(document).ready(function($){
	$("#AroSelector").on('change', function(){
		var page = $(this).val();
		if (page!=="") {
			location.href = "<?php echo $this->Html->url($params);?>/page:" + (parseInt(page)+1);
		}
	});
});
//]]>
</script>