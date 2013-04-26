<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'cvtermpath' table.
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
class CvtermpathTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.CvtermpathTableMap';

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
        $this->setName('cvtermpath');
        $this->setPhpName('Cvtermpath');
        $this->setClassname('cli_db\\propel\\Cvtermpath');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('cvtermpath_cvtermpath_id_seq');
        // columns
        $this->addPrimaryKey('cvtermpath_id', 'CvtermpathId', 'INTEGER', true, null, null);
        $this->addForeignKey('type_id', 'TypeId', 'INTEGER', 'cvterm', 'cvterm_id', false, null, null);
        $this->addForeignKey('subject_id', 'SubjectId', 'INTEGER', 'cvterm', 'cvterm_id', true, null, null);
        $this->addForeignKey('object_id', 'ObjectId', 'INTEGER', 'cvterm', 'cvterm_id', true, null, null);
        $this->addForeignKey('cv_id', 'CvId', 'INTEGER', 'cv', 'cv_id', true, null, null);
        $this->addColumn('pathdistance', 'Pathdistance', 'INTEGER', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Cv', 'cli_db\\propel\\Cv', RelationMap::MANY_TO_ONE, array('cv_id' => 'cv_id', ), 'CASCADE', null);
        $this->addRelation('CvtermRelatedByObjectId', 'cli_db\\propel\\Cvterm', RelationMap::MANY_TO_ONE, array('object_id' => 'cvterm_id', ), 'CASCADE', null);
        $this->addRelation('CvtermRelatedBySubjectId', 'cli_db\\propel\\Cvterm', RelationMap::MANY_TO_ONE, array('subject_id' => 'cvterm_id', ), 'CASCADE', null);
        $this->addRelation('CvtermRelatedByTypeId', 'cli_db\\propel\\Cvterm', RelationMap::MANY_TO_ONE, array('type_id' => 'cvterm_id', ), 'SET NULL', null);
    } // buildRelations()

} // CvtermpathTableMap
