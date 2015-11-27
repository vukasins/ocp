<?php

/**
 * 
 * @author Lajavi Krelac
 *
 */
class Libraries_i18n
{
    private static $instance = null;

    /**
     * @var bool
     */
    private $bigEndian = false;

    /**
     * @var resource
     */
    private $file = null;

    /**
     * @var array
     */
    private static $data = array();

    /**
     * @var string
     */
    private static $locale = 'en_US';

    /**
     * @param string $locale
     * @return Libraries_i18n
     */
    public function setLocale($locale)
    {
        self::$locale = $locale;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return self::$locale;
    }

    /**
     * @param string $module
     */
    public function loadTranslationForModule($module)
    {
        $filename = APPLICATION_ROOT_DIR . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . 'locale' . DIRECTORY_SEPARATOR . self::$locale . DIRECTORY_SEPARATOR . 'messages.mo';

        $this->bigEndian = false;
        $this->file = @fopen($filename, 'rb');

        //if (!$this->file) throw new Exception('Error opening translation file \'' . $filename . '\'.');
        if (!$this->file) return $this;
        if (@filesize($filename) < 10) throw new Exception('\'' . $filename . '\' is not a gettext file');

        // get Endian
        $input = $this->readMOData(1);
        if (strtolower(substr(dechex($input[1]), -8)) == "950412de")
        {
            $this->bigEndian = false;
        }
        else if (strtolower(substr(dechex($input[1]), -8)) == "de120495")
        {
            $this->bigEndian = true;
        }
        else
        {
            throw new Exception('\'' . $filename . '\' is not a gettext file');
        }

        // read revision - not supported for now
        $input = $this->readMOData(1);

        // number of bytes
        $input = $this->readMOData(1);
        $total = $input[1];

        // number of original strings
        $input = $this->readMOData(1);
        $OOffset = $input[1];

        // number of translation strings
        $input = $this->readMOData(1);
        $TOffset = $input[1];

        // fill the original table
        fseek($this->file, $OOffset);
        $origtemp = $this->readMOData(2 * $total);
        fseek($this->file, $TOffset);
        $transtemp = $this->readMOData(2 * $total);
        
        for($count = 0; $count < $total; ++$count)
        {
            if ($origtemp[$count * 2 + 1] != 0)
            {
                fseek($this->file, $origtemp[$count * 2 + 2]);
                $original = @fread($this->file, $origtemp[$count * 2 + 1]);
                $original = explode("\0", $original);
            }
            else
            {
                $original[0] = '';
            }

            if ($transtemp[$count * 2 + 1] != 0)
            {
                fseek($this->file, $transtemp[$count * 2 + 2]);
                $translate = fread($this->file, $transtemp[$count * 2 + 1]);
                $translate = explode("\0", $translate);
                
                if ((count($original) > 1) && (count($translate) > 1))
                {
                    self::$data[$locale][$original[0]] = $translate;
                    array_shift($original);

                    foreach ($original as $orig)
                    {
                        self::$data[self::$locale][$orig] = '';
                    }
                }
                else
                {
                    self::$data[self::$locale][$original[0]] = $translate[0];
                }
            }
        }
        
        self::$data[self::$locale][''] = trim(self::$data[self::$locale]['']);
        unset(self::$data[self::$locale]['']);

        return $this;
    }
    
    public function loadTranslationForAllModules() 
    {
        $modules_dir = APPLICATION_ROOT_DIR . DIRECTORY_SEPARATOR;
        $dir = dir($modules_dir);
        
        while(($row = $dir->read()) !== false)
        {
            if(!preg_match('/^\./', $row))
            {
                $module = $row;
                $this->loadTranslationForModule($module);
            }
        }
        
        return $this;
    }

    /**
     * 
     * @param string $msgid
     * @return string
     */
    public function __($msgid)
    {
        if(isset(self::$data[self::$locale]) && array_key_exists($msgid, self::$data[self::$locale])) 
        {
            return self::$data[self::$locale][$msgid];
        }

        return $msgid;
    }

    /**
     * 
     * @param int $bytes
     * @return array
     */
    private function readMOData($bytes)
    {
        if ($this->bigEndian === false)
        {
            return unpack('V' . $bytes, fread($this->file, 4 * $bytes));
        }
        else
        {
            return unpack('N' . $bytes, fread($this->file, 4 * $bytes));
        }
    }
    
    /**
     * @return Libraries_i18n
     */
    public static function getInstance() {
		return empty(self::$instance) ? self::$instance = new self() : self::$instance;
	}
}

// TODO: Ja cu da se trudim da ne bude ovako prljavih stvari, ali Poedit ne prepoznaje poziv metode
function __($msgid, $return = true)
{
    if($return === true)
    {
        return Libraries_i18n::getInstance()->__($msgid);
    }
    
    echo Libraries_i18n::getInstance()->__($msgid);
}