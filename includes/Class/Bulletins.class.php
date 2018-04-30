<?php


/*
    SERVER REMOTE CONSOLE
    Bulletins & Status Classes
    Developed by Maxel (marianosciacco.it)
*/




class Bulletin {

    private $file = null;
    private $time = null;
    private $priority = null;

    const folder = BULL_FOLDER;
    
    public function __construct($singlefile) 
    {


        if(file_exists(self::folder.$singlefile))
        {

            
            $date = explode("_", $singlefile);
            $pr = explode(".", $date[1]);
            

            $this->file = $singlefile;
            $this->time = $date[0]; 
            $this->priority = $pr[0];
            
        }
        else
        {
            No("File does not exists.");
            return; 
        }
    }

    private function PriorityName()
    {
        return Priority($this->priority);
    }

    private function PriorityColor()
    {
        switch ($this->priority) {
            case 1:
                return "primary";
                break;
            case 2: 
                return "info";
                break;
            case 3: 
                return "danger";
                break;
            default:
                return "secondary";
                break;
        }
    }

    public function getContent()
    {
        $handleFile = fopen(self::folder.$this->file, "r");
        $desc = fread($handleFile,filesize(self::folder.$this->file));
        fclose($handleFile);
        return $desc; 
    }

    public function Datetime($onlytime=0)
    {
        if($onlytime)
            return date("g:i a", $this->time);
        else
            return date("Y-m-d, g:i a", $this->time);
    }

    private function Description($inline=0)
    {
        return ($inline) ? $this->getContent() : "<br><p>".$this->getContent()."</p>";
    }

    public function Date()
    {
        return date("Y-m-d", $this->time);
    }

    public function getTimestamp()
    {
        return $this->time;
    }    

    public function getPriorityId()
    {
        return $this->priority;
    }

    public function View($asitem=0, $onlytime=0, $inline=0) 
    {
        $Title = $this->PriorityName();
        $Date = $this->Datetime($onlytime);
        $Description = $this->Description($inline);

        if($asitem) echo "<li class='list-group-item'>";
        echo $Title." <span class='badge badge-light'>".$Date."</span> ".$Description;
        if($asitem) echo "</li>";
    }
}



class Status
{
    const folder = "./store/";

    private $bulletins = array();

    public function __construct()
    {
        $this->bulletins = array_diff(scandir(self::folder), array('..', '.'));  
    }

    public function getLastBulletin()
    {
        arsort($this->bulletins);
        foreach($this->bulletins as $file)
        {
            return $file;
            break;
        }
    }

    public function List($maxnum=0)
    {
        echo "<ul class='list-group'>";
        arsort($this->bulletins);
        if($maxnum) $this->bulletins = array_slice($this->bulletins, 0, $maxnum);
        foreach ($this->bulletins as $file) 
        {
            $bulletin = new Bulletin($file);
            $bulletin->View(1, 0, 1);
        }
        echo "</ul>";
    }

    public function getTotalBulletins()
    {
        return count($this->bulletins);
    }

    private function OrderByPriority($ord)
    {
        // 0 == from highest
        // 1 == from lowest

        foreach ($this->bulletins as &$file)
        {
            $ex = explode("_", $file);
            $file = $ex[1]."_".$ex[0];
        }

        if(!$ord) arsort($this->bulletins);
        else asort($this->bulletins);

        foreach ($this->bulletins as &$file) 
        {
            $ex = explode("_", $file);
            $file = $ex[1]."_".$ex[0];
        }
    }

    public function ListAdmin($ord=0)
    {
        echo "<ul class='list-group'>";

        if($ord == 1) asort($this->bulletins);
        elseif($ord == 2) $this->OrderByPriority(0);
        elseif($ord == 3) $this->OrderByPriority(1);
        else arsort($this->bulletins);

        foreach ($this->bulletins as $file) 
        {
            $bulletin = new Bulletin($file);
            $file = CleanFileExt($file);
            echo "<li class='list-group-item'><a href='?bulletins&edit&file=$file' class='badge-warning badge'><i class='fa fa-pencil-alt'></i> Edit</a>
            <a href='?bulletins&delete&file=$file&a=1&ord=$ord' OnClick=\"return confirm('Confirm cancellation?')\" class='badge-dark badge'><i class='fa fa-trash-alt'></i> Delete</a> &raquo; ";
            $bulletin->View(0, 0, 1);
            echo "</li>";
        }
        echo "</ul>";
    }    

    public function ShowStatusBar($days)
    {
        $width = (100 / $days);

        echo "<div class='progress mt-2'>";
        for($i=$days; $i>=0; $i--)
        {   
            $time = time()-(86400*$i);
            $comp = date("Y-m-d", $time);
            $color = "success";
            foreach ($this->bulletins as $file) 
            {
                $bulletin = new Bulletin($file);
                $filedate = $bulletin->Date();
                if($filedate == $comp)
                {
                    $color = "warning";
                    break;
                }
                else 
                    continue;
            }

            $AnyBulletins = $comp.": ";
            $AnyBulletins .= $color=="success" ? "No incidents reported." : "Some bulletins have been submitted!";
            echo '<div class="progress-bar bg-'.$color.'" role="progressbar" style="width: '.$width.'%" aria-valuenow="'.$width.'" aria-valuemin="0" aria-valuemax="100" data-toggle="tooltip" data-placement="top" title="'.$AnyBulletins.'" onclick="location.replace(\'#'.$comp.'\')"></div>';
        } 
        echo "</div>";
        echo "<div class='text-muted clearfix mt-2 mb-4'><p class='float-left'>Last ".$days." days</p>";
        echo "<p class='float-right'>Today</p></div>";
    }

    public function ListAsCalendar($days)
    {
        for($i=0; $i<$days; $i++)
        {
            $time = time()-(86400*$i); 
            $day = date("M d, Y", $time);
            $comp = date("Y-m-d", $time);
            $flag = 0; 
            if($day == date("M d, Y")) $day .= " <small>(today)</small>";
            echo "<div class='clearfix'>
                    <h5 class='float-left' id=".$comp.">".$day." </h5>
                    <a class='text-muted float-right small' href='#'>Back to the top &uarr;</a>
                  </div>
                  <hr class='lesshigh'>";
            foreach ($this->bulletins as $file) 
            {
                $bulletin = new Bulletin($file);
                $filedate = $bulletin->Date();
                if($filedate == $comp)
                {
                    $bulletin->View(0, 1);
                    if(!$flag) $flag = 1;
                }
            }
            if(!$flag) echo "<p class='text-muted'>No bulletins submitted.</p>";
            echo "<br>";
        }
    }

}





?>