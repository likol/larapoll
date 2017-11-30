<?php
namespace Inani\Larapoll\Traits;


trait PollWriterResults
{
    /**
     * Draw the results of voting
     *
     * @param $poll
     */
    public function drawResult($poll)
    {
        $total = $poll->votes->count();
        $results = $poll->results()->grab();

        $this->drawBoxStart();
        $this->drawResultHeader($poll->question);
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
    public function drawResultHeader($question)
    {
        echo "<h5>投票結果: {$question}</h5>";
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
        <div class="col-md-6">
        <div class="featured-item career-box">';
    }

    public function drawBoxEnd()
    {
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
                <strong>{$result['option']->name}</strong><span class='pull-right'>{$percent}%</span>
                <progress class='progress' value='{$percent}' max='100'>
                    {$percent}%
                </progress>";
    }
}