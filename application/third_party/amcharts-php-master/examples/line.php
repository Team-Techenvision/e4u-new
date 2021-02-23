<?php

/*
 * This example shows how to create a simple line chart with a few configuration directives.
 * The values are from http://www.globalissues.org/article/26/poverty-facts-and-stats
 */

// Require necessary files
require("../lib/AmSerialChart.php");

// Create a new serial chart
$chart = new AmSerialChart("myLineChart");

// Set the path to the amcharts JS library
$chart->setLibraryPath("../amcharts");

// Set the X axes to represent the "year" field (optional)
$chart->setConfig("categoryField", "year");
// Use a chart cursor (optional)
$chart->setConfig("chartCursor", array("cursorPointer" => "mouse"));

// Add the data for the chart to use
$chart->setData(getData());

// Add 2 graphs
$graphConfigBolivia = array(
    "balloonText" => "[[title]]: [[value]] $", // Optional
);

$chart->addGraph("bolivia", $graphConfigBolivia);

$graphConfigArgentina = array(
    "balloonText" => "Argentina: [[value]] $" // Optional
);

$chart->addGraph("argentina", $graphConfigArgentina);

// Get the HTML/JS code
echo $chart->getCode();

/**
 * Return sample data
 * @return array
 {set:'Set7',value:60.00},{set:'Set8',value:20.00},{set:'Set9',value:30.00},{set:'Set10',value:0.00}
 */
function getData()
{
    return array(
        array( 
            "year" => 2000,
		  "bolivia" => 989,
        ),
        array(
            "bolivia" => 939, 
            "year" => 2001
        ),
        array(
            "bolivia" => 894,
            
            "year" => 2002
        ),
        array(
            "bolivia" => 955,
            
            "year" => 2003
        ),
        array(
            "bolivia" => 1021,
            
            "year" => 2004
        ),
        array(
            "bolivia" => 1203,
            
            "year" => 2005
        ),
        array(
            "bolivia" => 1356,
             
            "year" => 2006
        ),
        array(
            "bolivia" => 1696,
           
            "year" => 2007
        ),
        array(
            "bolivia" => 1735,
           
            "year" => 2008
        ),
        array(
            "bolivia" => 1935,
            
            "year" => 2009
        ),
        array(
            "bolivia" => 1925,
            
            "year" => 2010
        ),
    );
}
