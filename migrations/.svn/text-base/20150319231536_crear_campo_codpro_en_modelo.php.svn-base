<?php

use Phinx\Migration\AbstractMigration;

class CrearCampoCodproEnModelo extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     *
     * Uncomment this method if you would like to use it.
     */
    public function change()
    {
        $facturaprof = $this->table('facturaprof');
        $facturaprof->addColumn('estsolfacsiga', 'string', array('limit' => 500, 'null' => true))
              ->update();
    

        $users = $this->table('modelo');
        $users->addColumn('codpro', 'string', array('limit' => 50, 'null' => true))
              ->update();

    }
    
    /**
     * Migrate Up.
     */
    public function up()
    {

    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}