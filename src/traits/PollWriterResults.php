<?php
namespace Inani\Larapoll\Traits;


trait PollWriterResults
{

    protected $poll;
    /**
     * Draw the results of voting
     *
     * @param $poll
     */

    public function drawResult($poll)
    {
        $this->poll = $poll;
        $total = $this->poll->votes->count() + $this->poll->options->sum('votes');
        $results = $this->poll->results()->grab();

        $this->drawBoxStart();
        $this->drawResultHeader();
        $this->drawControlsStart();
        foreach($results as $result){
            $this->drawResultOption($result, $total);
        }
        $this->drawControlsEnd();
        $this->drawBoxEnd();
    }


    /**
     * The header text
     *
     * @param $question
     */
    public function drawResultHeader()
    {
        echo "<h5>投票結果: {$this->poll->question}</h5>";
    }

    public function drawControlsStart()
    {
        echo "<div class='controls-stacked'>";
    }

    public function drawControlsEnd()
    {
        echo "</div>";
    }

    public function drawBoxStart()
    {
        echo '
        <div class="row">
        <div class="col-md-12">
        <div class="featured-item career-box">';
    }

    public function drawBoxEnd()
    {
        echo "<span class='v-date'>投票期間: {$this->poll->start_at->format('Y-m-d H:i')} ~ {$this->poll->end_at->format('Y-m-d H:i')}</span>";
        echo '</div></div></div>';
    }

    /**
     * Draw each option result
     *
     * @param $result
     * @param $total
     */
    public function drawResultOption($result, $total)
    {
        $votes = $result['votes'];
        if($total == 0){
            $percent = 0;
        }else{
            $percent = ($votes * 100) /($total);
        }
        echo "
                <strong>{$result['option']->name}</strong><span class='pull-right'>{$votes} 票</span>
                <progress class='progress' value='{$percent}' max='100'>
                    {$percent}%
                </progress>";
    }
}