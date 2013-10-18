<?php
/**
 * Class RPagerHelper
 * @author: Raysmond
 */
class RPagerHelper
{
    // Pager id to differentiate pagers in a page
    private $pageId;

    // Total records sum
    private $rowSum;

    // Records sum in a page
    private $rowsInPage;

    // Page sum
    private $pageSum;

    private $url;

    private $curPage;


    public $pagerText = array(
        'first' => "First",
        'last' => 'Last',
        'prev' => '&laquo;',
        'next' => '&raquo;',
    );

    public function __construct($pageId, $rowSum, $rowsInPage = 10, $url = '',$curPage=1)
    {
        $this->pageId = trim($pageId);
        $this->rowSum = $rowSum;
        $this->rowsInPage = $rowsInPage;
        $this->url = $url;
        $this->pageSum = ceil($rowSum / $rowsInPage);
        $this->curPage = $curPage;
    }

    public function showPager($showPrev = true, $showNext = true, $showFirst = true, $showLast = true, $pagesViewNum = 10)
    {
        $pager = '<ul id="pager-'.$this->pageId.'" class="pagination">';
        $isOdd = $pagesViewNum % 2 > 0 ? true : false;
        $curPage = 1;
        if (isset($_GET[$this->pageId]))
            $curPage = $_GET[$this->pageId];

        $appendStr = '?';
        if(strpos($this->url,'?')>0)
            $appendStr = '&&';

        if ($showFirst) {
            $pager .= '<li class="pager-item"><a href="' . $this->url . $appendStr . $this->pageId . '=1">' . $this->pagerText['first'] . '</a></li>';
        }
        if ($showPrev) {
            $num = $curPage == 1 ? 1 : ($curPage - 1);
            $pager .= '<li class="pager-item"><a href="' . $this->url . $appendStr . $this->pageId . '=' . $num . '">' . $this->pagerText['prev'] . '</a></li>';
        }

        $beginPage = 1;
        $count = $pagesViewNum;
        if (($this->pageSum > $pagesViewNum) && $curPage > ($pagesViewNum / 2)) {
            $pager .= '<li class="pager-item"><a href="#">...</a></li>';
            $beginPage = $curPage - ceil($pagesViewNum / 2) + 1;
            if ($isOdd) $beginPage++;
            $count--;
        }

        $leftMore = 0;
        $insertRight = false;
        if (($this->pageSum - $curPage) > ($pagesViewNum / 2)) {
            $insertRight = true;
            $count--;
        } else {
            $leftMore = ceil($pagesViewNum / 2) - $this->pageSum + $curPage;
            if (!$isOdd) $beginPage++;
            if ($isOdd) $leftMore--;
        }

        for ($i = 0; $i < $count; $i++) {
            if (($num = $beginPage + $i - $leftMore) <= $this->pageSum) {
                if($num<=0) continue;
                $pager .= '<li class="pager-item '.(($num==$this->curPage)?'active':'').'"><a href="' . $this->url . $appendStr . $this->pageId . '=' . ($num) . '">' . ($num) . '</a></li>';
            }
        }

        if ($insertRight) {
            $pager .= '<li class="pager-item"><a href="#">...</a></li>';
        }

        if ($showNext) {
            $num = ($curPage == $this->pageSum ? $this->pageSum : ($curPage + 1));
            $pager .= '<li class="pager-item"><a href="' . $this->url . $appendStr . $this->pageId . '=' . $num . '">' . $this->pagerText['next'] . '</a></li>';
        }


        if ($showLast) {
            $pager .= '<li class="pager-item"><a href="' . $this->url . $appendStr . $this->pageId . '=' . $this->pageSum . '">' . $this->pagerText['last'] . '</a></li>';
        }
        $pager.="</ul>";
        return $pager;
    }
}
