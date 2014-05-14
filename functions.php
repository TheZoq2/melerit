<?php
	class TableRow
	{
		private $htmlData;

		private $contentArray; //Array containing all the content to be added to the row

		function __construct($htmlData, $contentArray)
		{
			$this->htmlData = $htmlData;

			if(is_array($contentArray))
			{
				$this->contentArray = $contentArray;
			}
			else
			{
				$this->contentArray = array();
			}
		}

		function addContent($content)
		{
			$contentArray[] = $content;
		}

		function getString()
		{
			$result = "<tr " . $this->htmlData . ">";

			foreach($this->contentArray as $content)
			{
				$result .= "<td>" . $content . "</content>";
			}

			$result .= "</tr>";

			return $result;
		}
	}

	class Table
	{
		private $htmlData;

		private $rows;

		function __construct($htmlData, $firstRow)
		{
			$this->htmlData = $htmlData;

			$this->rows = array();

			$this->addRow($firstRow); //Add the first row to the table
		}
		function addRow($row)
		{
			//Making sure the right stuff is put into the rows
			if(($row instanceof TableRow) == false)
			{
				$row = new TableRow("", array());
			}

			$this->rows[] = $row;

		}
		function addRawRow($htmlData, $contentArray)
		{
			addRow(new TableRow($htmlData, $contentArray);
		}

		//Return a string with the HTML code for the table
		function getString()
		{
			$result = "<table " . $this->htmlData . ">";

			foreach($this->rows as $row)
			{
				$result .= $row->getString();
			}

			$result .= "</table>";

			return $result;
		}
	}

	class ParamBase()
	{
		function __construct($minVal, $maxVal, $minValOK, $maxValOK)
		{
			$this->minVal = $minVal;
			$this->maxVal = $maxVal;
			$this->minValOk = $minValOk;
			$this->maxValOk = $maxValOk;
		}

		function getMinVal()
		{
			return $this->minVal;
		}
		function getMaxVal()
		{
			return $this->maxVal;
		}
		function getMinValOk()
		{
			return $this->minValOk;
		}
		function getMaxValOk()
		{
			return $this->maxValOk;
		}

		private $minVal;
		private $maxVal;
		private $minValOK;
		private $maxValOK;
	}
?>