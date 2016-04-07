<?php
header('Content-type: text/xml');
require_once 'includes/recipe.php';
$recipes = \Cooking\Recipe::allRecipes("");
$output = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
$output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
ob_clean();
echo $output;
?>
<url>
    <loc>http://paperplatedad.com/</loc>
    <lastmod>2016-04-07T20:31:20-07:00</lastmod>
    <changefreq>weekly</changefreq>
  </url>
  <url>
    <loc>http://paperplatedad.com/about.php</loc>
    <lastmod>2016-04-07T20:31:20-07:00</lastmod>
    <changefreq>monthly</changefreq>
  </url>
  <url>
    <loc>http://paperplatedad.com/contact.php</loc>
    <lastmod>2016-04-07T20:31:20-07:00</lastmod>
    <changefreq>yearly</changefreq>
  </url>
  <?php
foreach($recipes as $recipe){
    ?>
<url>
  <loc>http://paperplatedad.com/showRecipe.php?name=<?=urlencode($recipe['Title'])?></loc>
<?php
$datetime = new DateTime($recipe['DateModified']);
$result = $datetime->format('Y-m-d\TH:i:sP');
?>
  <lastmod><?=$result?></lastmod>
  <changefreq>weekly</changefreq>
</url><?php
}
?>
</urlset>
