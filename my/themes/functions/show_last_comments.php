 <?php
$rows = DB::query_fetch_all("SELECT u.name, c.text FROM {comments} AS c
LEFT JOIN {users} AS u ON c.user_id=u.id WHERE c.act='1' AND c.trash='0'
ORDER BY c.id DESC LIMIT 5");
$text = '';
foreach ($rows as $row)
{
    $text .= $row['text'].'<br>';
}
echo $text;