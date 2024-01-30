<div class="heading">
    <h3><span>SEARCH</span></h3>
</div>
<div class="search-container">
    <input type="text" name="searchkey" class="search-input" placeholder="Search books, authors...">
    <button type="submit" name="searchsubmit" class="search-button">🔍</button>
</div>
<br>
<div class="heading">
    <h3><span>POPULAR AUTHORS</span></h3>
</div>
<?php
$authorResultRows = fetchDataById('authors', '', 'ID, name, details', 'ORDER BY authors.ID DESC');

$x = 5;
foreach($authorResultRows as $author) {
    if(!$x) break;
    echo'<div class="author-sm-card">';
    echo'<span class="author-name"><img src="avatar.jpg" alt="author"></span>';
    echo'<span class="author-name">'.$author['name'].'</span>';
    echo'</div>';
    $x--;
}
?>