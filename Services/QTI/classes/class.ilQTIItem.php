<?php
/*
    +-----------------------------------------------------------------------------+
    | ILIAS open source                                                           |
    +-----------------------------------------------------------------------------+
    | Copyright (c) 1998-2001 ILIAS open source, University of Cologne            |
    |                                                                             |
    | This program is free software; you can redistribute it and/or               |
    | modify it under the terms of the GNU General Public License                 |
    | as published by the Free Software Foundation; either version 2              |
    | of the License, or (at your option) any later version.                      |
    |                                                                             |
    | This program is distributed in the hope that it will be useful,             |
    | but WITHOUT ANY WARRANTY; without even the implied warranty of              |
    | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the               |
    | GNU General Public License for more details.                                |
    |                                                                             |
    | You should have received a copy of the GNU General Public License           |
    | along with this program; if not, write to the Free Software                 |
    | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA. |
    +-----------------------------------------------------------------------------+
*/

define("QT_UNKNOWN", "unknown");
define("QT_KPRIM_CHOICE", "assKprimChoice");
define("QT_LONG_MENU", "assLongMenu");
define("QT_MULTIPLE_CHOICE_SR", "assSingleChoice");
define("QT_MULTIPLE_CHOICE_MR", "assMultipleChoice");
define("QT_CLOZE", "assClozeTest");
define("QT_ERRORTEXT", "assErrorText");
define("QT_MATCHING", "assMatchingQuestion");
define("QT_ORDERING", "assOrderingQuestion");
define("QT_ORDERING_HORIZONTAL", "assOrderingHorizontal");
define("QT_IMAGEMAP", "assImagemapQuestion");
define("QT_JAVAAPPLET", "assJavaApplet");
define("QT_FLASHAPPLET", "assFlashApplet");
define("QT_TEXT", "assTextQuestion");
define("QT_FILEUPLOAD", "assFileUpload");
define("QT_NUMERIC", "assNumeric");
define("QT_FORMULA", "assFormulaQuestion");
define("QT_TEXTSUBSET", "assTextSubset");

/**
* QTI item class
*
* @author Helmut Schottm??ller <hschottm@gmx.de>
* @version $Id$
*
* @package assessment
*/
class ilQTIItem
{
    public $ident;
    public $title;
    public $maxattempts;
    public $label;
    public $xmllang;
    
    public $comment;
    public $ilias_version;
    public $author;
    public $questiontype;
    public $duration;
    public $questiontext;
    public $resprocessing;
    public $itemfeedback;
    public $presentation;
    public $presentationitem;
    public $suggested_solutions;
    public $itemmetadata;
    
    protected $iliasSourceVersion;
    protected $iliasSourceNic;
    
    public function __construct()
    {
        $this->response = array();
        $this->resprocessing = array();
        $this->itemfeedback = array();
        $this->presentation = null;
        $this->presentationitem = array();
        $this->suggested_solutions = array();
        $this->itemmetadata = array();
        
        $this->iliasSourceVersion = null;
        $this->iliasSourceNic = null;
    }
    
    public function setIdent($a_ident)
    {
        $this->ident = $a_ident;
    }
    
    public function getIdent()
    {
        return $this->ident;
    }
    
    public function setTitle($a_title)
    {
        $this->title = $a_title;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function setComment($a_comment)
    {
        if (preg_match("/(.*?)\=(.*)/", $a_comment, $matches)) {
            // special comments written by ILIAS
            switch ($matches[1]) {
                case "ILIAS Version":
                    $this->ilias_version = $matches[2];
                    return;
                    break;
                case "Questiontype":
                    $this->questiontype = $matches[2];
                    return;
                    break;
                case "Author":
                    $this->author = $matches[2];
                    return;
                    break;
            }
        }
        $this->comment = $a_comment;
    }
    
    public function getComment()
    {
        return $this->comment;
    }
    
    public function setDuration($a_duration)
    {
        if (preg_match("/P(\d+)Y(\d+)M(\d+)DT(\d+)H(\d+)M(\d+)S/", $a_duration, $matches)) {
            $this->duration = array(
                "h" => $matches[4],
                "m" => $matches[5],
                "s" => $matches[6]
            );
        }
    }
    
    public function getDuration()
    {
        return $this->duration;
    }
    
    public function setQuestiontext($a_questiontext)
    {
        $this->questiontext = $a_questiontext;
    }
    
    public function getQuestiontext()
    {
        return $this->questiontext;
    }
    
    public function addResprocessing($a_resprocessing)
    {
        array_push($this->resprocessing, $a_resprocessing);
    }
    
    public function addItemfeedback($a_itemfeedback)
    {
        array_push($this->itemfeedback, $a_itemfeedback);
    }
    
    public function setMaxattempts($a_maxattempts)
    {
        $this->maxattempts = $a_maxattempts;
    }
    
    public function getMaxattempts()
    {
        return $this->maxattempts;
    }
    
    public function setLabel($a_label)
    {
        $this->label = $a_label;
    }
    
    public function getLabel()
    {
        return $this->label;
    }
    
    public function setXmllang($a_xmllang)
    {
        $this->xmllang = $a_xmllang;
    }
    
    public function getXmllang()
    {
        return $this->xmllang;
    }
    
    public function setPresentation($a_presentation)
    {
        $this->presentation = $a_presentation;
    }
    
    public function getPresentation()
    {
        return $this->presentation;
    }
    
    public function collectResponses()
    {
        $result = array();
        if ($this->presentation != null) {
        }
    }
    
    public function setQuestiontype($a_questiontype)
    {
        $this->questiontype = $a_questiontype;
    }
    
    public function getQuestiontype()
    {
        return $this->questiontype;
    }
    
    public function addPresentationitem($a_presentationitem)
    {
        array_push($this->presentationitem, $a_presentationitem);
    }

    public function determineQuestionType()
    {
        switch ($this->questiontype) {
            case "ORDERING QUESTION":
                return QT_ORDERING;
            case "KPRIM CHOICE QUESTION":
                return QT_KPRIM_CHOICE;
            case "LONG MENU QUESTION":
                return QT_LONG_MENU;
            case "SINGLE CHOICE QUESTION":
                return QT_MULTIPLE_CHOICE_SR;
            case "MULTIPLE CHOICE QUESTION":
                break;
            case "MATCHING QUESTION":
                return QT_MATCHING;
            case "CLOZE QUESTION":
                return QT_CLOZE;
            case "IMAGE MAP QUESTION":
                return QT_IMAGEMAP;
            case "JAVA APPLET QUESTION":
                return QT_JAVAAPPLET;
            case "TEXT QUESTION":
                return QT_TEXT;
            case "NUMERIC QUESTION":
                return QT_NUMERIC;
            case "TEXTSUBSET QUESTION":
                return QT_TEXTSUBSET;
        }
        if (!$this->presentation) {
            return QT_UNKNOWN;
        }
        foreach ($this->presentation->order as $entry) {
            switch ($entry["type"]) {
                case "response":
                    $response = $this->presentation->response[$entry["index"]];
                    switch ($response->getResponsetype()) {
                        case RT_RESPONSE_LID:
                            switch ($response->getRCardinality()) {
                                case R_CARDINALITY_ORDERED:
                                    return QT_ORDERING;
                                    break;
                                case R_CARDINALITY_SINGLE:
                                    return QT_MULTIPLE_CHOICE_SR;
                                    break;
                                case R_CARDINALITY_MULTIPLE:
                                    return QT_MULTIPLE_CHOICE_MR;
                                    break;
                            }
                            break;
                        case RT_RESPONSE_XY:
                            return QT_IMAGEMAP;
                            break;
                        case RT_RESPONSE_STR:
                            switch ($response->getRCardinality()) {
                                case R_CARDINALITY_ORDERED:
                                    return QT_TEXT;
                                    break;
                                case R_CARDINALITY_SINGLE:
                                    return QT_CLOZE;
                                    break;
                            }
                            break;
                        case RT_RESPONSE_GRP:
                            return QT_MATCHING;
                            break;
                        default:
                            break;
                    }
                    break;
                case "material":
                    $material = $this->presentation->material[$entry["index"]];
                    if (is_array($material->matapplet) && count($material->matapplet) > 0) {
                        return QT_JAVAAPPLET;
                    }
                    break;
            }
        }
        if (strlen($this->questiontype) == 0) {
            return QT_UNKNOWN;
        } else {
            return $this->questiontype;
        }
    }
    
    public function setAuthor($a_author)
    {
        $this->author = $a_author;
    }
    
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getIliasSourceVersion()
    {
        return $this->iliasSourceVersion;
    }

    /**
     * @param string $iliasSourceVersion
     */
    public function setIliasSourceVersion($iliasSourceVersion)
    {
        $this->iliasSourceVersion = $iliasSourceVersion;
    }

    /**
     * @return null
     */
    public function getIliasSourceNic()
    {
        return $this->iliasSourceNic;
    }

    /**
     * @param null $iliasSourceNic
     */
    public function setIliasSourceNic($iliasSourceNic)
    {
        $this->iliasSourceNic = $iliasSourceNic;
    }
    
    public function addSuggestedSolution($a_solution, $a_gap_index)
    {
        array_push($this->suggested_solutions, array("solution" => $a_solution, "gap_index" => $a_gap_index));
    }
    
    public function addMetadata($a_metadata)
    {
        array_push($this->itemmetadata, $a_metadata);
    }
    
    public function getMetadata()
    {
        return $this->itemmetadata;
    }
    
    public function getMetadataEntry($a_label)
    {
        foreach ($this->itemmetadata as $metadata) {
            if (strcmp($metadata["label"], $a_label) == 0) {
                return $metadata["entry"];
            }
        }
        return null;
    }
}
