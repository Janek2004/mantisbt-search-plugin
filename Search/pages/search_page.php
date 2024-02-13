<link rel="stylesheet" type="text/css" href="<?php echo plugin_file('style.css') ?>" />

<?php

layout_page_header();
layout_page_begin();

function make_status_button($enabled, $bug_id)
{
	$action = plugin_page('mark_enabled.php');

	if ($enabled == 80) {
		return "<form action='$action' method='post'>
		<input type='hidden' name='id' value='$bug_id'/>
		<input type='hidden' name='action' value='undo'/>
		<input type='submit' class='btn btn-success btn-white btn-sm btn-round' value='Rozwiązany'/>
		</form>";
	} else {
		return "<form action='$action' method='post'>
		<input type='hidden' name='id' value='$bug_id'/>
		<input type='hidden' name='action' value='end'/>
		<input type='submit' class='btn btn-danger btn-white btn-sm btn-round' value='Rozwiąż'/>
		</form>";
	}
}

?>

<h2>Search</h2>

<form method='post' action=''>
	<input autocomplete="off" name="search_by_name" type="text" class="form-control" style="margin-bottom: 4px;"
		placeholder="Szukaj po nazwie..." />
</form>

<?= isset($_POST['search_by_name']) ? "<a style='margin-bottom: 8px;' href='" . plugin_page('search_page') . "' class='badge badge-primary'>" . $_POST['search_by_name'] . "</a>" : null ?>

<table class="table table-striped">
	<tr>
		<th>ID</th>
		<th>Nazwa</th>
		<th>Opis</th>
		<th>Status</th>
		<th>Data dodania</th>
		<th>Edycja</th>
	</tr>
	<?php

	$by_name = isset($_POST['search_by_name']) ? $_POST['search_by_name'] : '';

	$s_bugs = event_signal('EVENT_SEARCH_GETBUGS', array($by_name));

	foreach ($s_bugs as $bug) {

		// FIXME: Find a better way to get this link
	
		$href = "/praca/view.php?id=" . $bug['id'];

		//$table_class = $bug['status'] != 80 ? 'table-danger' : 'table-success';
	
		echo "<tr>";

		echo "<th><a href='$href' class='link'>" . $bug['id'] . "</a></th>";
		echo "<td><a href='$href' class='link'>" . $bug['name'] . "</a></td>";
		echo "<td>" . $bug['description'] . "</td>";
		echo "<td>" . make_status_button($bug['status'], $bug['id']) . "</td>";

		$bug_date = date('m/d/Y, H:i', $bug['date_submitted']);
		echo "<td>" . $bug_date . "</td>";
		echo "<td><a href='$href' class='btn btn-primary btn-white'>Edytuj</a></td>";

		echo "</tr>";
	}

	?>
</table>

<?php
layout_page_end();
