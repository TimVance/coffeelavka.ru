 <?php
$rows = DB::query_fetch_all("SELECT name1 FROM {payment}");
$text = '';
foreach ($rows as $row)
{
    $text .= $row['name1'].'<br>';
}
echo $text;