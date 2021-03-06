<?php

/**
 * Class ilBiblRisFileReader
 *
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class ilBiblTexFileReader extends ilBiblFileReaderBase implements ilBiblFileReaderInterface
{

    /**
     * @var array
     */
    protected static $ignored_keywords = array( 'Preamble' );


    /**
     * @inheritdoc
     */
    public function parseContent()
    {
        $this->convertBibSpecialChars();
        $this->normalizeContent();

        // get entries
        $subject = $this->getFileContent();
        $objects = preg_split("/\\@([\\w]*)/uix", $subject, null, PREG_SPLIT_DELIM_CAPTURE
                                                                  | PREG_SPLIT_NO_EMPTY);

        if (in_array($objects[0], self::$ignored_keywords)) {
            $objects = array_splice($objects, 2);
        }
        // some files lead to a empty first entry in the array with the fist bib-entry, we have to trow them away...
        if (strlen($objects[0]) <= 3) {
            $objects = array_splice($objects, 1);
        }

        $entries = array();
        foreach ($objects as $key => $object) {
            if ((int) $key % 2 == 0 || (int) $key == 0) {
                $entry = array();
                $entry['entryType'] = strtolower($object);
            } else {
                // Citation
                preg_match("/^{(?<cite>.*),\\n/um", $object, $cite_matches);
                if ($cite_matches['cite']) {
                    $entry['cite'] = $cite_matches['cite'];
                }

                // Edit at regex101.com: (?<attr>[\w]*)\s*=\s*[{"]*(?<content>(.*?))\s*[}"]*?\s*[,]*?\s*\n
                $re = "/(?<attr>[\\w]*)\\s*=\\s*[{\"]*(?<content>(.*?))\\s*[}\"]*?\\s*[,]*?\\s*\\n/";

                preg_match_all($re, $object, $matches, PREG_SET_ORDER);

                foreach ($matches as $match) {
                    $clean = $match['content'];
                    $clean = preg_replace("/[\", \\t\\s]*\\n/u", "\n", $clean);

                    $entry[strtolower($match['attr'])] = $clean;
                }

                $entries[] = $entry;
            }
        }

        return $entries;
    }


    /**
     * @inheritdoc
     */
    protected function normalizeContent()
    {
        $result = $this->removeBomUtf8($this->getFileContent());
        // remove emty newlines
        $result = preg_replace("/^\n/um", "", $result);
        // Remove lines with only whitespaces
        $result = preg_replace("/^[\\s]*$/um", "\n", $result);
        $result = preg_replace("/\\n\\n\\n/um", "\n\n", $result);

        // remove comments
        $result = preg_replace("/^%.*\\n/um", "", $result);

        // Intend attributes with a tab
        $result = preg_replace("/^[ ]+/um", "\t", $result);
        $result = preg_replace("/^([\\w])/um", "\t$1", $result);

        // replace newline-braktes with brakets
        $result = preg_replace('/\\n}/uimx', '}', $result);

        // move last bracket on newline
        $result = preg_replace("/}[\\s]*$/um", "\n}", $result);

        // Support long lines (not working at the moment)
        //		$re = "/(\"[^\"\\n]*)\\r?\\n(?!(([^\"]*\"){2})*[^\"]*$)/";
        //		$subst = "$1";
        //		$result = preg_replace($re, $subst, $result);

        $this->setFileContent($result);
    }


    protected function convertBibSpecialChars()
    {
        $bibtex_special_chars['??'] = '{\"a}';
        $bibtex_special_chars['??'] = '{\"e}';
        $bibtex_special_chars['??'] = '{\"i}';
        $bibtex_special_chars['??'] = '{\"o}';
        $bibtex_special_chars['??'] = '{\"u}';
        $bibtex_special_chars['??'] = '{\"A}';
        $bibtex_special_chars['??'] = '{\"E}';
        $bibtex_special_chars['??'] = '{\"I}';
        $bibtex_special_chars['??'] = '{\"O}';
        $bibtex_special_chars['??'] = '{\"U}';
        $bibtex_special_chars['??'] = '{\^a}';
        $bibtex_special_chars['??'] = '{\^e}';
        $bibtex_special_chars['??'] = '{\^i}';
        $bibtex_special_chars['??'] = '{\^o}';
        $bibtex_special_chars['??'] = '{\^u}';
        $bibtex_special_chars['??'] = '{\^A}';
        $bibtex_special_chars['??'] = '{\^E}';
        $bibtex_special_chars['??'] = '{\^I}';
        $bibtex_special_chars['??'] = '{\^O}';
        $bibtex_special_chars['??'] = '{\^U}';
        $bibtex_special_chars['??'] = '{\`a}';
        $bibtex_special_chars['??'] = '{\`e}';
        $bibtex_special_chars['??'] = '{\`i}';
        $bibtex_special_chars['??'] = '{\`o}';
        $bibtex_special_chars['??'] = '{\`u}';
        $bibtex_special_chars['??'] = '{\`A}';
        $bibtex_special_chars['??'] = '{\`E}';
        $bibtex_special_chars['??'] = '{\`I}';
        $bibtex_special_chars['??'] = '{\`O}';
        $bibtex_special_chars['??'] = '{\`U}';
        $bibtex_special_chars['??'] = '{\\\'a}';
        $bibtex_special_chars['??'] = '{\\\'e}';
        $bibtex_special_chars['??'] = '{\\\'i}';
        $bibtex_special_chars['??'] = '{\\\'o}';
        $bibtex_special_chars['??'] = '{\\\'u}';
        $bibtex_special_chars['??'] = '{\\\'A}';
        $bibtex_special_chars['??'] = '{\\\'E}';
        $bibtex_special_chars['??'] = '{\\\'I}';
        $bibtex_special_chars['??'] = '{\\\'O}';
        $bibtex_special_chars['??'] = '{\\\'U}';
        $bibtex_special_chars['??'] = '{\`a}';
        $bibtex_special_chars['??'] = '{\`e}';
        $bibtex_special_chars['??'] = '{\`i}';
        $bibtex_special_chars['??'] = '{\`o}';
        $bibtex_special_chars['??'] = '{\`u}';
        $bibtex_special_chars['??'] = '{\`A}';
        $bibtex_special_chars['??'] = '{\`E}';
        $bibtex_special_chars['??'] = '{\`I}';
        $bibtex_special_chars['??'] = '{\`O}';
        $bibtex_special_chars['??'] = '{\`U}';
        $bibtex_special_chars['??'] = '{\c c}';
        $bibtex_special_chars['??'] = '{\ss}';
        $bibtex_special_chars['??'] = '{\~n}';
        $bibtex_special_chars['??'] = '{\~N}';
        $bibtex_special_chars['??'] = "{\\'n}";
        $bibtex_special_chars['l'] = "{\\'n}";
        $bibtex_special_chars['&'] = "{\&}";
        $bibtex_special_chars['@'] = "{\@}";

        $this->setFileContent(str_replace(array_values($bibtex_special_chars), array_keys($bibtex_special_chars), $this->getFileContent()));
    }


    /**
     * @param $s
     *
     * @return bool|string
     */
    protected function removeBomUtf8($s)
    {
        if (substr($s, 0, 3) == chr(hexdec('EF')) . chr(hexdec('BB')) . chr(hexdec('BF'))) {
            return substr($s, 3);
        } else {
            return $s;
        }
    }
}
