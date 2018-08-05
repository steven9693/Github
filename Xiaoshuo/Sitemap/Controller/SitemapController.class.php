<?php

namespace Sitemap\Controller;
use Think\Controller;


class SitemapController extends Controller {

    public function sitemap() {

        $list = M('books')->where(array('isshow'=>1))->order('bookid desc')->limit(10000)->select();
        $sitemap = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n".
        "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\r\n";
        foreach($list as $k=>$v){
            $sitemap .= "<url>\r\n".
                "<loc>http://www.migiweb.com/index.php/mp3/".$v['bookid'].".html</loc>\r\n".
                "<priority>0.8</priority>\r\n<lastmod>".date('Y-m-d',$v['ctime']).
                "</lastmod>\r\n<changefreq>weekly</changefreq>\r\n</url>\r\n";
        }
        $sitemap .= '</urlset>';
        $file = fopen("sitemap.xml","w");
        fwrite($file,$sitemap);
        fclose($file);
//        $this->success('地图生成成功');
    }

}
