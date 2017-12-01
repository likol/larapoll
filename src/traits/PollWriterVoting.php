<?php
namespace Inani\Larapoll\Traits;

use Illuminate\Support\Facades\Session;
use Inani\Larapoll\Poll;

trait PollWriterVoting
{
    /**
     * Drawing the poll for checkbox case
     *
     * @param Poll $poll
     */
    public function drawCheckbox(Poll $poll)
    {
        $options = $poll->options->pluck('name', 'id');
        $this->startForm($poll->id);
        $this->drawStartHeaderPanel();
        $this->drawHeader($poll->question, $poll->description);
        $this->drawEndHeaderPanel();

        $this->drawStartOptionsPanel();
        foreach($options as $id => $name){
            $this->drawOptionCheckbox($id, $name);
        }
        $this->drawEndOptionsPanel();
        $this->endForm();
    }

    /**
     * Draw checkbox option
     *
     * @param $id
     * @param $name
     */
    public function drawOptionCheckbox($id, $name)
    {
        echo "
            <li class=\"list-group-item\">
            <label class=\"control checkbox\">
				<input type='checkbox' name='options[]' value={$id} />
				<span class=\"control-indicator\"></span>
				{$name}
			</label>
			</li>
        ";
    }

    /**
     * Drawing the poll for the radio case
     *
     * @param Poll $poll
     */
    public function drawRadio(Poll $poll)
    {
        $options = $poll->options->pluck('name', 'id');
        $this->startForm($poll->id);
        $this->drawStartHeaderPanel();
        $this->drawHeader($poll->question, $poll->description);
        $this->drawEndHeaderPanel();

        $this->drawStartOptionsPanel();
        foreach($options as $id => $name){
            $this->drawOption($id, $name);
        }
        $this->drawEndOptionsPanel();
        $this->endForm();
    }

    /**
     * Print errors/success messages
     */
    public function showFeedBack()
    {
        if(Session::has('errors')){
            echo '<div class="alert alert-success">';
            echo session('errors');
            echo '</div>';
        }
        if(Session::has('success')){
            echo '<div class="alert alert-success">';
            echo session('success');
            echo '</div>';
        }
    }

    /**
     * Draw the start form tag
     *
     * @param $id
     */
    public function startForm($id)
    {
        echo '
        <div class="row">
        <div class="col-md-6">
        <form method="POST" action="'. route('poll.vote', $id).'" >
        ';
    }

    /**
     *  Close the form tag
     */
    public function endForm()
    {
        if (\Auth::user())
        {
            echo '<div class="col-md-12 text-center"><input type="submit" class="btn btn-small btn-dark-solid" value="投票" /></div></form></div></div></div>';
        } else
        {
            echo '<div class="col-md-12 text-center"><a href="' . route('user::loginForm') . '" class="btn btn-small btn-dark-solid">登入投票</a></div></form></div></div></div>';
        }
    }

    /**
     *  Start Header Panel
     */
    public function drawStartHeaderPanel()
    {
        echo '
            <div class="featured-item career-box">
                <div class="icon text-center"><i class="icon-basic_pin1"></i></div>
                <div class="heading-title-alt border-short-bottom text-center" style="margin-bottom: 15px">
            ';
    }

    public function drawEndHeaderPanel()
    {
        echo '
            </div>
            ';
    }

    /**
     * Draw the header block
     *
     * @param $question
     */
    public function drawHeader($question, $descrtipion)
    {
        echo '
        <div class="title text-uppercase"><h4>'
        . $question .
        '</h4></div>
        <div class="desc">'
        . $descrtipion .
        '</div>';
    }

    /**
     *  Start of the list Panel
     */
    public function drawStartOptionsPanel()
    {
        echo '
        <div class="panel-body">
                    <ul class="list-group">';
    }

    /**
     *  End of the list Panel
     */
    public function drawEndOptionsPanel()
    {
        echo '                    </ul>
                </div>';
    }

    /**
     * Draw the radio of option
     *
     * @param $id
     * @param $name
     */
    public function drawOption($id, $name)
    {
        echo '
            <li class="list-group-item">
                <label class="control radio">
                    <input value='.$id.' type="radio" name="options">
                    <span class="control-indicator"></span>
                    '. $name .'
                </label>
            </li>
        ';
    }
}