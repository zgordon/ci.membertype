<html>
<head>
<title>Member Types</title>
<style type="text/css">
table {border-collapse:collapse; border:1px #ccc solid}
td, th {border:1px #ccc solid; padding: 5px}
th {background: #222; color: #fff}
</style>
</head>
<body>

<h1>Members View</h1>

<table>
	<theader>
	<th>Member</th>
	<th>Membertypes</th>
	<th>Save</th>
	</theader>
	<?php foreach($members as $member): ?>
	<?= form_open('members/update_member_membertypes'); ?>
	<?= form_hidden('member_id', $member['member_id']); ?>
	<tr>
		<td><?= $member['screen_name']; ?></td>
		<td>
			<?= $member['membertype_checkbox']; ?>
			<? //list_membertypes($member['membertypes']); ?>
		</td>
		<td>
			<?= form_submit('submit', 'Update'); ?>
		</td>
	</tr>		
	<?= form_close(); ?>
	<?php endforeach; ?>
</table>

<h2>List of member types</h2>
<table>
	<theader>
	<th>Id</th>
	<th>Membertypes</th>
	<th>Save</th>
	</theader>
	<td>
	
	<?= form_open('members/add_membertype'); ?>
	<tr>		
		<td>New</td>
		<td><?= form_input('membertype_name'); ?></td>	
		<td><?= form_submit('submit', 'Add'); ?></td>
	</tr>	
	<?= form_close(); ?>
	
	
	<?php foreach($membertypes as $membertype): ?>
	<?= form_open('members/delete_membertype'); ?>
	<?= form_hidden('membertype_id', $membertype['membertype_id']); ?>
	<tr>
		<td><?= $membertype['membertype_id']; ?></td>
		<td><?= $membertype['membertype_name']; ?></td>	
		<td><?= form_submit('submit', 'Delete'); ?></td>
	</tr>	
	<?= form_close(); ?>
	<?php endforeach; ?>
</table>
</body>
</html>