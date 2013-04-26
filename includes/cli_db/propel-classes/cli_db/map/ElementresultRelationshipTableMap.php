<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'elementresult_relationship' table.
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
class ElementresultRelationshipTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.ElementresultRelationshipTableMap';

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
        $this->setName('elementresult_relationship');
        $this->setPhpName('ElementresultRelationship');
        $this->setClassname('cli_db\\propel\\ElementresultRelationship');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('elementresult_relationship_elementresult_relationship_id_seq');
        // columns
        $this->addPrimaryKey('elementresult_relationship_id', 'ElementresultRelationshipId', 'INTEGER', true, null, null);
        $this->addForeignKey('subject_id', 'SubjectId', 'INTEGER', 'elementresult', 'elementresult_id', true, null, null);
        $this->addForeignKey('type_id', 'TypeId', 'INTEGER', 'cvterm', 'cvterm_id', true, null, null);
        $this->addForeignKey('object_id', 'ObjectId', 'INTEGER', 'elementresult', 'elementresult_id', true, null, null);
        $this->addColumn('value', 'Value', 'LONGVARCHAR', false, null, null);
        $this->addColumn('rank', 'Rank', 'INTEGER', true, null, 0);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('ElementresultRelatedByObjectId', 'cli_db\\propel\\Elementresult', RelationMap::MANY_TO_ONE, array('object_id' => 'elementresult_id', ), null, null);
        $this->addRelation('ElementresultRelatedBySubjectId', 'cli_db\\propel\\Elementresult', RelationMap::MANY_TO_ONE, array('subject_id' => 'elementresult_id', ), null, null);
        $this->addRelation('Cvterm', 'cli_db\\propel\\Cvterm', RelationMap::MANY_TO_ONE, array('type_id' => 'cvterm_id', ), null, null);
    } // buildRelations()

} // ElementresultRelationshipTableMap
