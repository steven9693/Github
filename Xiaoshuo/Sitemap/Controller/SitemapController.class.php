<?php

namespace Sitemap\Controller;
use Think\Controller;


class SitemapController extends Controller {

    public function sitemap() {

        $num=0;

        $list = M('books')->where(array('isshow'=>1))->limit(10000)->select();


        $startmap = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n".
            "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\r\n";
        $sitemap=$startmap;
        foreach($list as $k=>$v){
            $sitemap.="<url>\r\n".
                "<loc>http://www.migiweb.com/mp3/".$v['bookid'].".html</loc>\r\n".
                "<priority>0.8</priority>\r\n<lastmod>".date('Y-m-d',$v['ctime']).
                "</lastmod>\r\n<changefreq>weekly</changefreq>\r\n</url>\r\n";

            if(($k%1400==0&&$k!=0)||$k==(count($list)-1)){ //1400条的时候进行分文件
                $sitemap.= '</urlset>';
                if($num==0){
                    $file = fopen("sitemap.xml","w");
                }else{
                    $file = fopen("sitemap_$num.xml","w");
                }

                $flag = fwrite($file,$sitemap);
                fclose($file);
                $num+=1;
                $sitemap=$startmap;
            }
        }


//        if($flag){
//            header("Location: ".'./index.php?m=Index&c=Index&a=success');
//        }

//        $this->success('地图生成成功');
    }
    
    public function success(){
        $this->display();
    }

}
