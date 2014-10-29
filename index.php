<?php 
//wordpress permalink compatibility
if (isset($_GET['p'])) {header("Location: old/".$_GET['p']); die();}
require_once 'config.php';
require_once 'prefs.php';
require_once 'Markdown.php';
require_once 'functions.php';
use \Michelf\Markdown;
$requested_file = str_replace('/'.$folder, "", $_SERVER['REQUEST_URI']);
if ($requested_file != '' && !file_exists('content/'.$requested_file.".md")) {
    header("HTTP/1.0 404 Not Found");
    $requested_file = '404';
}
if ($requested_file == '') {
    $is_front_page = true; 
    $oldposts = glob('content/old/*.md');
    $posts = glob('content/posts/*.md');
    $posts = array_merge($oldposts, $posts);
    foreach ($posts as $post_file){
        $post = file_get_contents($post_file);
        $postmeta = parseMeta($post_file);
        if ($postmeta['Status']!='Draft'){
            $post_html = Markdown::defaultTransform($post);
            $post_html = preg_replace('#/\*(.*?)\*/#ms', '', $post_html);
            if (isset($postmeta['Date']))
                $timestamp = strtotime($postmeta['Date']);
            if (!isset($newposts[$timestamp])) $key = $timestamp; else $key = $timestamp+1;

            $newposts[$key]=array();
            $newposts[$key]['file']=str_replace("content/","",str_replace(".md", '', $post_file));
            $newposts[$key]['meta']=$postmeta;
            $newposts[$key]['html']=$post_html;
            $newposts[$key]['excerpt']=truncate(strip_tags($post_html,"<p><a><pre><code>"),$excerpt_length);
        }
    }
    $posts = $newposts;
    ksort($posts);
    $posts = array_reverse($posts, true);
} else {
    $is_front_page = false;
    
    $post_file = 'content/'.$requested_file.'.md';
    $post = file_get_contents($post_file);
    $meta = parseMeta($post_file);

    $post_html = Markdown::defaultTransform($post);
    $post_html = preg_replace('#/\*(.*?)\*/#ms', '', $post_html);
    //the negative lookahead is for backward compatibility
    //we are allowing 'real' paths so that both the site and IDE's render content ok
    $post_html = preg_replace('#src=../(?!content/)#', 'src=../content/', $post_html);
}

$pages = glob('content/pages/*.md');
$newpages = array();
foreach ($pages as $page){
    $pagemeta = parseMeta($page);
    $newpages[$pagemeta['title']]=str_replace("content/","",str_replace(".md", '', $page));
}
$pages = $newpages;

$themeName = 'themes/'.$theme;
$theme = "/".$folder.'themes/'.$theme;

include "$themeName/template.php";
