<?php
namespace Pagenav;

class Pagenav{ 
    
    public function pagenav($count,$pagesize,$url){ 
        //$count 总条数
        //$pagesize单页的条数
        //$url url路径
        
        $count=$count; //总的数据量
        $Page_size=$pagesize; //单页显示的条数
        
        $page_count = ceil($count/$Page_size);  //总页数

        $init=1; 
        $page_len=7; 
        $max_p=$page_count; 
        $pages=$page_count; 

        //判断当前页码 
        if(empty($_GET['page'])||$_GET['page']<0){ 
            $page=1; 
        }else { 
            $page=$_GET['page']; 
        } 
        
        $page_len = ($page_len%2)?$page_len:$page_len+1;//页码个数 
        $pageoffset = ($page_len-1)/2;//页码个数左右偏移量


        $key='<div class="page">'; 
        //$key.="<span>$page/$pages</span> "; //第几页,共几页 
        if($page!=1){ 
            $key.="<a href=\"".$url."&page=".($page-1)."\">上一页</a>"; //上一页 
            if($page>4&&$page_count>7){
                $key.="<a href=\"".$url."&page=1\">1</a> "; //第一页 
                $key.="<span>...</span>";
            }

        }else { 
            $key.="<a href='javascript:void(0)'>上一页</a>"; //上一页 
            //$key.="<a href='javascript:void(0)'>1</a> ";//第一页 
        } 
        if($pages>$page_len){ 
            //如果当前页小于等于左偏移 
            if($page<=$pageoffset){ 
                $init=1; 
                $max_p = $page_len; 
            }else{//如果当前页大于左偏移 
                //如果当前页码右偏移超出最大分页数 
                if($page+$pageoffset>=$pages+1){ 
                    $init = $pages-$page_len+1; 
                }else{ 
                    //左右偏移都存在时的计算 
                    $init = $page-$pageoffset; 
                    $max_p = $page+$pageoffset; 
                } 
            } 
        } 
        //for($i=$init;$i<=$max_p;$i++){
        for($i=$init;$i<$max_p;$i++){    
            if($i==$page){
                $key.=' <a class="current" href="javascript:void(0)">'.$i.'</a>'; 
            } else {
                $key.=" <a href=\"".$url."&page=".$i."\">".$i."</a>"; 
            } 
        } 
        //echo $max_p;
        if($page!=$pages){
            if($max_p<$pages){
                $key.='<span>...</span>';
            }
            $key.="<a href=\"".$url."&page={$pages}\">{$pages}</a>"; //最后一页 
            $key.=" <a href=\"".$url."&page=".($page+1)."\">下一页</a> ";//下一页 
        }else {
            
            $key.="<a href=\"".$url."&page={$pages}\" class=\"current\">{$pages}</a>"; //最后一页 
            $key.="<a href='javascript:void(0)'>下一页</a> ";//下一页 
            
        }
        $key.='<span class="allpage">共'.$page_count.'页';
        $key.='，到第<input id="setpage" class="setpage" value="" />页<a href="javascript:void(0)" class="topage" onclick="gotopage()">确定</a></span>';
        $key.='</div><script>function gotopage(){var topage=document.getElementById("setpage").value;maxpage='.$pages.';if(topage>maxpage){topage=maxpage};var href="'.$url.'&page=";window.location.href=href+topage}</script>';
//        $key.='</div>';
        return $key;
    }
}
?>