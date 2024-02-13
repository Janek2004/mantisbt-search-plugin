<?php
class SearchPlugin extends MantisPlugin
{

    function register()
    {
        $this->name = 'Search Plugin';
        $this->description = 'A simple plugin to search through the reports.';
        $this->page = 'search_page.php';

        $this->version = '1.0.0';
        $this->requires = array("MantisCore" => "2.0.0");

        $this->author = 'Jan Zagórski';
        $this->contact = 'jan.zagorski04@gmail.com';
        $this->url = 'https:/github.com/Janek2004';
    }

    function events()
    {
        return array(
            'EVENT_SEARCH_GETBUGS' => EVENT_TYPE_CHAIN,
        );
    }

    function hooks()
    {
        return array(
            'EVENT_MENU_MAIN' => 'menu',
            'EVENT_SEARCH_GETBUGS' => 'get_bugs'
        );
    }

    function api()
    {

    }

    function menu()
    {
        $t_menu[] = array(
            'title' => $this->name,
            'url' => plugin_page('search_page'),
            'access_level' => ADMINISTRATOR,
            'icon' => 'fa-search'
        );
        return $t_menu;
    }

    function get_bugs($ev, $filter)
    {

        $conn = new mysqli('localhost', 'root', '', 'bugtracker');

        $q = "SELECT mantis_bug_text_table.id, mantis_bug_table.summary as 'name', mantis_bug_text_table.description, mantis_bug_table.status, mantis_bug_table.date_submitted FROM mantis_bug_table INNER JOIN mantis_bug_text_table ON mantis_bug_table.bug_text_id = mantis_bug_text_table.id WHERE mantis_bug_table.summary like '$filter%';";

        $res = $conn->query($q);

        $conn->close();

        $rows = [];

        while ($row = $res->fetch_array()) {
            $rows[] = $row;
        }

        return $rows;

    }

}
