<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'treatment' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.cli_db.map
 */
class TreatmentTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.TreatmentTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('treatment');
        $this->setPhpName('Treatment');
        $this->setClassname('cli_db\\propel\\Treatment');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('treatment_treatment_id_seq');
        // columns
        $this->addPrimaryKey('treatment_id', 'TreatmentId', 'INTEGER', true, null, null);
        $this->addColumn('rank', 'Rank', 'INTEGER', true, null, 0);
        $this->addForeignKey('biomaterial_id', 'BiomaterialId', 'INTEGER', 'biomaterial', 'biomaterial_id', true, null, null);
        $this->addForeignKey('type_id', 'TypeId', 'INTEGER', 'cvterm', 'cvterm_id', true, null, null);
        $this->addForeignKey('protocol_id', 'ProtocolId', 'INTEGER', 'protocol', 'protocol_id', false, null, null);
        $this->addColumn('name', 'Name', 'LONGVARCHAR', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Biomaterial', 'cli_db\\propel\\Biomaterial', RelationMap::MANY_TO_ONE, array('biomaterial_id' => 'biomaterial_id', ), 'CASCADE', null);
        $this->addRelation('Protocol', 'cli_db\\propel\\Protocol', RelationMap::MANY_TO_ONE, array('protocol_id' => 'protocol_id', ), 'SET NULL', null);
        $this->addRelation('Cvterm', 'cli_db\\propel\\Cvterm', RelationMap::MANY_TO_ONE, array('type_id' => 'cvterm_id', ), 'CASCADE', null);
        $this->addRelation('BiomaterialTreatment', 'cli_db\\propel\\BiomaterialTreatment', RelationMap::ONE_TO_MANY, array('treatment_id' => 'treatment_id', ), 'CASCADE', null, 'BiomaterialTreatments');
    } // buildRelations()

} // TreatmentTableMap
