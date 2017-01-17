<div>
        <div style="border-bottom:#666666 1px solid; color: #006699; font-size: 15px; font-weight:bold; margin-bottom:5px">
        ANALISA STATUS PROJEK MENGIKUT TAHUN
        </div>
        <div>
        <form name="theForm" method="post">
        <table width="100%" border="1" bordercolor="#FFFFFF" bordercolorlight="#CCCCCC" cellpadding="0" cellspacing="0" style="padding:2px; width:100%; border:#999999 1px solid"> 
        <tr>
        <td>Status Projek</td>
        <td colspan="3">
        <select name="selStatus">
            <option value="">--Semua--</option>
            <option value="1">Awal</option>
            <option value="2">Mengikut Jadual</option>
            <option value="3">Lewat</option>
        </select></td>
        </tr>
        <tr>
        <td>Tahun</td>	
        <td width="90%">
        <select name="selTahun" >
        <option value="">--Semua--</option>
        <?php 
        $year=date('Y');
        while($year!=1990){
            ?>
            <option value="<?php echo $year?>"><?php echo $year?></option>
            <?php
            $year--;	
        }
        ?>
        </select></td>		
        <tr>	
        <td colspan="5" style="background-color:#666666">
            <p>
              <input type="submit" name="btn_cari" value="Papar" title="Papar" class="button"  />
              <input type="reset" name="btn_reset" value="Set Semula" title="Set Semula" class="button"/>
              <input type="button" name="btn_cancel" value="Batal" title="Batal" class="button" onclick="history.back()"/>
            </p></td>
        </tr>
        </table>
        </form>
        </div>
        
        <?php 
        if(isset($_POST['btn_cari'])){		  
             include 'GrafStatus.php';
             ?>
            </div>
            <?php
        }
        ?>
</div>