<section>
<article>
<h1><?php echo $osvisitors; ?> <span class="pull-right">Help</span></h1>
This is a Visitors system for Open Simulator
</article>

<article>
    <h2>Features</h2>
    Visitors List with sorting<br />
    Search ability for visitor, grid, region, parcel<br />
    More coming ...
</article>

<article>
    <h2>Requierment</h2>
    Mysql, Php5, Apache<br />
    Ossl enable
</article>

<article>
    <h2>Download</h2>
    <a class="btn btn-default btn-success btn-xs" href="https://github.com/djphil/osvisitors" target="_blank">
    <i class="glyphicon glyphicon-save"></i> GithHub</a> Source Code
</article>

<article>
    <h2>Install</h2>
    <h3>osslEnable.ini</h3>
    <pre>
    [XEngine]
    AllowOSFunctions = true 
    </pre>
    <p>And you should allow the following ossl functions to the parcel owner/manager</p>
    <pre>
    osIsNpc
    osGetGridName
    osGetGridNick
    osGetGender
    </pre>

    <h3>Database</h3>
    <ul>
        <li>Create a database called "osmodules".</li>
        <li>Import osvisitors_inworld.sql into "osmodules" database.</li>
    </ul>

    <h3>inc/config.php</h3>
    <ul>
        <li>Configure file</li>
    </ul>

    <h3>Super Admin</h3>
    <ul>
        <li>reorder id <a href="?reorder">here</a></li>
        <li>update flags <a href="?update">here</a></li>
        <li>delete all visitors <a href="?delete">here</a></li>
    </ul>
</article>

<article id="AddVisitors">
    <h2>Add Visitors</h2>
    Only the region/parcel owner is authorised to add a Visitor to the OpenSim Visitors.
    <h3>Inword:</h3>
    <ol>
        <li>Download the OpenSim Visitors Terminal script (LSL).</li>
        <li>Copy the OpenSim Visitors Terminal script into a prim, configure and compile it.<br />
            (configurable variables: baseurl, tempoat, resetat, textchat).
        </li>
        <li>Click on the prim to update your Visitors informations in the OpenSim Visitors.</li>
    </ol>
    <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#terminal">
    <i class="glyphicon glyphicon-save"></i> Download</button> OpenSim Visitors Terminal
</article>

<article>
    <h2>License</h2>
    GNU/GPL General Public License v3.0<br />
</article>

<article>
    <h2>Credit</h2>
    Philippe Lemaire (djphil)
</article>

<article>
    <h2>Donation</h2>
    <p><?php include_once("inc/paypal.php"); ?></p>
</article>

<div class="modal fade" id="terminal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">OpenSim Visitors Terminal v0.1.lsl</h4>
            </div>
            <div class="modal-body">
                <?php
                $file = file_get_contents('lsl/Visitors Terminal v0.1.lsl', true);
                echo '<pre>'.$file.'</pre>';
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</section>
