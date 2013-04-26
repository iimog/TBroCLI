<?php

namespace cli_db\propel\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use cli_db\propel\AcquisitionPeer;
use cli_db\propel\AcquisitionRelationship;
use cli_db\propel\AcquisitionRelationshipPeer;
use cli_db\propel\CvtermPeer;
use cli_db\propel\map\AcquisitionRelationshipTableMap;

/**
 * Base static class for performing query and update operations on the 'acquisition_relationship' table.
 *
 *
 *
 * @package propel.generator.cli_db.om
 */
abstract class BaseAcquisitionRelationshipPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'cli_db';

    /** the table name for this class */
    const TABLE_NAME = 'acquisition_relationship';

    /** the related Propel class for this table */
    const OM_CLASS = 'cli_db\\propel\\AcquisitionRelationship';

    /** the related TableMap class for this table */
    const TM_CLASS = 'AcquisitionRelationshipTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 6;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 6;

    /** the column name for the acquisition_relationship_id field */
    const ACQUISITION_RELATIONSHIP_ID = 'acquisition_relationship.acquisition_relationship_id';

    /** the column name for the subject_id field */
    const SUBJECT_ID = 'acquisition_relationship.subject_id';

    /** the column name for the type_id field */
    const TYPE_ID = 'acquisition_relationship.type_id';

    /** the column name for the object_id field */
    const OBJECT_ID = 'acquisition_relationship.object_id';

    /** the column name for the value field */
    const VALUE = 'acquisition_relationship.value';

    /** the column name for the rank field */
    const RANK = 'acquisition_relationship.rank';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identiy map to hold any loaded instances of AcquisitionRelationship objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array AcquisitionRelationship[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. AcquisitionRelationshipPeer::$fieldNames[AcquisitionRelationshipPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('AcquisitionRelationshipId', 'SubjectId', 'TypeId', 'ObjectId', 'Value', 'Rank', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('acquisitionRelationshipId', 'subjectId', 'typeId', 'objectId', 'value', 'rank', ),
        BasePeer::TYPE_COLNAME => array (AcquisitionRelationshipPeer::ACQUISITION_RELATIONSHIP_ID, AcquisitionRelationshipPeer::SUBJECT_ID, AcquisitionRelationshipPeer::TYPE_ID, AcquisitionRelationshipPeer::OBJECT_ID, AcquisitionRelationshipPeer::VALUE, AcquisitionRelationshipPeer::RANK, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ACQUISITION_RELATIONSHIP_ID', 'SUBJECT_ID', 'TYPE_ID', 'OBJECT_ID', 'VALUE', 'RANK', ),
        BasePeer::TYPE_FIELDNAME => array ('acquisition_relationship_id', 'subject_id', 'type_id', 'object_id', 'value', 'rank', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. AcquisitionRelationshipPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('AcquisitionRelationshipId' => 0, 'SubjectId' => 1, 'TypeId' => 2, 'ObjectId' => 3, 'Value' => 4, 'Rank' => 5, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('acquisitionRelationshipId' => 0, 'subjectId' => 1, 'typeId' => 2, 'objectId' => 3, 'value' => 4, 'rank' => 5, ),
        BasePeer::TYPE_COLNAME => array (AcquisitionRelationshipPeer::ACQUISITION_RELATIONSHIP_ID => 0, AcquisitionRelationshipPeer::SUBJECT_ID => 1, AcquisitionRelationshipPeer::TYPE_ID => 2, AcquisitionRelationshipPeer::OBJECT_ID => 3, AcquisitionRelationshipPeer::VALUE => 4, AcquisitionRelationshipPeer::RANK => 5, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ACQUISITION_RELATIONSHIP_ID' => 0, 'SUBJECT_ID' => 1, 'TYPE_ID' => 2, 'OBJECT_ID' => 3, 'VALUE' => 4, 'RANK' => 5, ),
        BasePeer::TYPE_FIELDNAME => array ('acquisition_relationship_id' => 0, 'subject_id' => 1, 'type_id' => 2, 'object_id' => 3, 'value' => 4, 'rank' => 5, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
    );

    /**
     * Translates a fieldname to another type
     *
     * @param      string $name field name
     * @param      string $fromType One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                         BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @param      string $toType   One of the class type constants
     * @return string          translated name of the field.
     * @throws PropelException - if the specified name could not be found in the fieldname mappings.
     */
    public static function translateFieldName($name, $fromType, $toType)
    {
        $toNames = AcquisitionRelationshipPeer::getFieldNames($toType);
        $key = isset(AcquisitionRelationshipPeer::$fieldKeys[$fromType][$name]) ? AcquisitionRelationshipPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(AcquisitionRelationshipPeer::$fieldKeys[$fromType], true));
        }

        return $toNames[$key];
    }

    /**
     * Returns an array of field names.
     *
     * @param      string $type The type of fieldnames to return:
     *                      One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                      BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @return array           A list of field names
     * @throws PropelException - if the type is not valid.
     */
    public static function getFieldNames($type = BasePeer::TYPE_PHPNAME)
    {
        if (!array_key_exists($type, AcquisitionRelationshipPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return AcquisitionRelationshipPeer::$fieldNames[$type];
    }

    /**
     * Convenience method which changes table.column to alias.column.
     *
     * Using this method you can maintain SQL abstraction while using column aliases.
     * <code>
     *		$c->addAlias("alias1", TablePeer::TABLE_NAME);
     *		$c->addJoin(TablePeer::alias("alias1", TablePeer::PRIMARY_KEY_COLUMN), TablePeer::PRIMARY_KEY_COLUMN);
     * </code>
     * @param      string $alias The alias for the current table.
     * @param      string $column The column name for current table. (i.e. AcquisitionRelationshipPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(AcquisitionRelationshipPeer::TABLE_NAME.'.', $alias.'.', $column);
    }

    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param      Criteria $criteria object containing the columns to add.
     * @param      string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(AcquisitionRelationshipPeer::ACQUISITION_RELATIONSHIP_ID);
            $criteria->addSelectColumn(AcquisitionRelationshipPeer::SUBJECT_ID);
            $criteria->addSelectColumn(AcquisitionRelationshipPeer::TYPE_ID);
            $criteria->addSelectColumn(AcquisitionRelationshipPeer::OBJECT_ID);
            $criteria->addSelectColumn(AcquisitionRelationshipPeer::VALUE);
            $criteria->addSelectColumn(AcquisitionRelationshipPeer::RANK);
        } else {
            $criteria->addSelectColumn($alias . '.acquisition_relationship_id');
            $criteria->addSelectColumn($alias . '.subject_id');
            $criteria->addSelectColumn($alias . '.type_id');
            $criteria->addSelectColumn($alias . '.object_id');
            $criteria->addSelectColumn($alias . '.value');
            $criteria->addSelectColumn($alias . '.rank');
        }
    }

    /**
     * Returns the number of rows matching criteria.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @return int Number of matching rows.
     */
    public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
    {
        // we may modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AcquisitionRelationshipPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AcquisitionRelationshipPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(AcquisitionRelationshipPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(AcquisitionRelationshipPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        // BasePeer returns a PDOStatement
        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }
    /**
     * Selects one object from the DB.
     *
     * @param      Criteria $criteria object used to create the SELECT statement.
     * @param      PropelPDO $con
     * @return                 AcquisitionRelationship
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = AcquisitionRelationshipPeer::doSelect($critcopy, $con);
        if ($objects) {
            return $objects[0];
        }

        return null;
    }
    /**
     * Selects several row from the DB.
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con
     * @return array           Array of selected Objects
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelect(Criteria $criteria, PropelPDO $con = null)
    {
        return AcquisitionRelationshipPeer::populateObjects(AcquisitionRelationshipPeer::doSelectStmt($criteria, $con));
    }
    /**
     * Prepares the Criteria object and uses the parent doSelect() method to execute a PDOStatement.
     *
     * Use this method directly if you want to work with an executed statement directly (for example
     * to perform your own object hydration).
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con The connection to use
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return PDOStatement The executed PDOStatement object.
     * @see        BasePeer::doSelect()
     */
    public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AcquisitionRelationshipPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            AcquisitionRelationshipPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(AcquisitionRelationshipPeer::DATABASE_NAME);

        // BasePeer returns a PDOStatement
        return BasePeer::doSelect($criteria, $con);
    }
    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doSelect*()
     * methods in your stub classes -- you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by doSelect*()
     * and retrieveByPK*() calls.
     *
     * @param      AcquisitionRelationship $obj A AcquisitionRelationship object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getAcquisitionRelationshipId();
            } // if key === null
            AcquisitionRelationshipPeer::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param      mixed $value A AcquisitionRelationship object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof AcquisitionRelationship) {
                $key = (string) $value->getAcquisitionRelationshipId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or AcquisitionRelationship object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(AcquisitionRelationshipPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return   AcquisitionRelationship Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(AcquisitionRelationshipPeer::$instances[$key])) {
                return AcquisitionRelationshipPeer::$instances[$key];
            }
        }

        return null; // just to be explicit
    }

    /**
     * Clear the instance pool.
     *
     * @return void
     */
    public static function clearInstancePool($and_clear_all_references = false)
    {
      if ($and_clear_all_references)
      {
        foreach (AcquisitionRelationshipPeer::$instances as $instance)
        {
          $instance->clearAllReferences(true);
        }
      }
        AcquisitionRelationshipPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to acquisition_relationship
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return string A string version of PK or null if the components of primary key in result array are all null.
     */
    public static function getPrimaryKeyHashFromRow($row, $startcol = 0)
    {
        // If the PK cannot be derived from the row, return null.
        if ($row[$startcol] === null) {
            return null;
        }

        return (string) $row[$startcol];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $startcol = 0)
    {

        return (int) $row[$startcol];
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function populateObjects(PDOStatement $stmt)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = AcquisitionRelationshipPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = AcquisitionRelationshipPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = AcquisitionRelationshipPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AcquisitionRelationshipPeer::addInstanceToPool($obj, $key);
            } // if key exists
        }
        $stmt->closeCursor();

        return $results;
    }
    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return array (AcquisitionRelationship object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = AcquisitionRelationshipPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = AcquisitionRelationshipPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + AcquisitionRelationshipPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AcquisitionRelationshipPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            AcquisitionRelationshipPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }


    /**
     * Returns the number of rows matching criteria, joining the related AcquisitionRelatedByObjectId table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAcquisitionRelatedByObjectId(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AcquisitionRelationshipPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AcquisitionRelationshipPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(AcquisitionRelationshipPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AcquisitionRelationshipPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AcquisitionRelationshipPeer::OBJECT_ID, AcquisitionPeer::ACQUISITION_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related AcquisitionRelatedBySubjectId table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAcquisitionRelatedBySubjectId(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AcquisitionRelationshipPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AcquisitionRelationshipPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(AcquisitionRelationshipPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AcquisitionRelationshipPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AcquisitionRelationshipPeer::SUBJECT_ID, AcquisitionPeer::ACQUISITION_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related Cvterm table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinCvterm(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AcquisitionRelationshipPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AcquisitionRelationshipPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(AcquisitionRelationshipPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AcquisitionRelationshipPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AcquisitionRelationshipPeer::TYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Selects a collection of AcquisitionRelationship objects pre-filled with their Acquisition objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AcquisitionRelationship objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAcquisitionRelatedByObjectId(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AcquisitionRelationshipPeer::DATABASE_NAME);
        }

        AcquisitionRelationshipPeer::addSelectColumns($criteria);
        $startcol = AcquisitionRelationshipPeer::NUM_HYDRATE_COLUMNS;
        AcquisitionPeer::addSelectColumns($criteria);

        $criteria->addJoin(AcquisitionRelationshipPeer::OBJECT_ID, AcquisitionPeer::ACQUISITION_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AcquisitionRelationshipPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AcquisitionRelationshipPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = AcquisitionRelationshipPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AcquisitionRelationshipPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = AcquisitionPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = AcquisitionPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = AcquisitionPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    AcquisitionPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (AcquisitionRelationship) to $obj2 (Acquisition)
                $obj2->addAcquisitionRelationshipRelatedByObjectId($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of AcquisitionRelationship objects pre-filled with their Acquisition objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AcquisitionRelationship objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAcquisitionRelatedBySubjectId(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AcquisitionRelationshipPeer::DATABASE_NAME);
        }

        AcquisitionRelationshipPeer::addSelectColumns($criteria);
        $startcol = AcquisitionRelationshipPeer::NUM_HYDRATE_COLUMNS;
        AcquisitionPeer::addSelectColumns($criteria);

        $criteria->addJoin(AcquisitionRelationshipPeer::SUBJECT_ID, AcquisitionPeer::ACQUISITION_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AcquisitionRelationshipPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AcquisitionRelationshipPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = AcquisitionRelationshipPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AcquisitionRelationshipPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = AcquisitionPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = AcquisitionPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = AcquisitionPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    AcquisitionPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (AcquisitionRelationship) to $obj2 (Acquisition)
                $obj2->addAcquisitionRelationshipRelatedBySubjectId($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of AcquisitionRelationship objects pre-filled with their Cvterm objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AcquisitionRelationship objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinCvterm(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AcquisitionRelationshipPeer::DATABASE_NAME);
        }

        AcquisitionRelationshipPeer::addSelectColumns($criteria);
        $startcol = AcquisitionRelationshipPeer::NUM_HYDRATE_COLUMNS;
        CvtermPeer::addSelectColumns($criteria);

        $criteria->addJoin(AcquisitionRelationshipPeer::TYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AcquisitionRelationshipPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AcquisitionRelationshipPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = AcquisitionRelationshipPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AcquisitionRelationshipPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = CvtermPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = CvtermPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = CvtermPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    CvtermPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (AcquisitionRelationship) to $obj2 (Cvterm)
                $obj2->addAcquisitionRelationship($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining all related tables
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAll(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AcquisitionRelationshipPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AcquisitionRelationshipPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(AcquisitionRelationshipPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AcquisitionRelationshipPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AcquisitionRelationshipPeer::OBJECT_ID, AcquisitionPeer::ACQUISITION_ID, $join_behavior);

        $criteria->addJoin(AcquisitionRelationshipPeer::SUBJECT_ID, AcquisitionPeer::ACQUISITION_ID, $join_behavior);

        $criteria->addJoin(AcquisitionRelationshipPeer::TYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }

    /**
     * Selects a collection of AcquisitionRelationship objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AcquisitionRelationship objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AcquisitionRelationshipPeer::DATABASE_NAME);
        }

        AcquisitionRelationshipPeer::addSelectColumns($criteria);
        $startcol2 = AcquisitionRelationshipPeer::NUM_HYDRATE_COLUMNS;

        AcquisitionPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AcquisitionPeer::NUM_HYDRATE_COLUMNS;

        AcquisitionPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + AcquisitionPeer::NUM_HYDRATE_COLUMNS;

        CvtermPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + CvtermPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(AcquisitionRelationshipPeer::OBJECT_ID, AcquisitionPeer::ACQUISITION_ID, $join_behavior);

        $criteria->addJoin(AcquisitionRelationshipPeer::SUBJECT_ID, AcquisitionPeer::ACQUISITION_ID, $join_behavior);

        $criteria->addJoin(AcquisitionRelationshipPeer::TYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AcquisitionRelationshipPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AcquisitionRelationshipPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = AcquisitionRelationshipPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AcquisitionRelationshipPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined Acquisition rows

            $key2 = AcquisitionPeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = AcquisitionPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = AcquisitionPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AcquisitionPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (AcquisitionRelationship) to the collection in $obj2 (Acquisition)
                $obj2->addAcquisitionRelationshipRelatedByObjectId($obj1);
            } // if joined row not null

            // Add objects for joined Acquisition rows

            $key3 = AcquisitionPeer::getPrimaryKeyHashFromRow($row, $startcol3);
            if ($key3 !== null) {
                $obj3 = AcquisitionPeer::getInstanceFromPool($key3);
                if (!$obj3) {

                    $cls = AcquisitionPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    AcquisitionPeer::addInstanceToPool($obj3, $key3);
                } // if obj3 loaded

                // Add the $obj1 (AcquisitionRelationship) to the collection in $obj3 (Acquisition)
                $obj3->addAcquisitionRelationshipRelatedBySubjectId($obj1);
            } // if joined row not null

            // Add objects for joined Cvterm rows

            $key4 = CvtermPeer::getPrimaryKeyHashFromRow($row, $startcol4);
            if ($key4 !== null) {
                $obj4 = CvtermPeer::getInstanceFromPool($key4);
                if (!$obj4) {

                    $cls = CvtermPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    CvtermPeer::addInstanceToPool($obj4, $key4);
                } // if obj4 loaded

                // Add the $obj1 (AcquisitionRelationship) to the collection in $obj4 (Cvterm)
                $obj4->addAcquisitionRelationship($obj1);
            } // if joined row not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining the related AcquisitionRelatedByObjectId table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptAcquisitionRelatedByObjectId(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AcquisitionRelationshipPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AcquisitionRelationshipPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(AcquisitionRelationshipPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AcquisitionRelationshipPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AcquisitionRelationshipPeer::TYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related AcquisitionRelatedBySubjectId table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptAcquisitionRelatedBySubjectId(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AcquisitionRelationshipPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AcquisitionRelationshipPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(AcquisitionRelationshipPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AcquisitionRelationshipPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AcquisitionRelationshipPeer::TYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related Cvterm table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptCvterm(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AcquisitionRelationshipPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AcquisitionRelationshipPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(AcquisitionRelationshipPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AcquisitionRelationshipPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AcquisitionRelationshipPeer::OBJECT_ID, AcquisitionPeer::ACQUISITION_ID, $join_behavior);

        $criteria->addJoin(AcquisitionRelationshipPeer::SUBJECT_ID, AcquisitionPeer::ACQUISITION_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Selects a collection of AcquisitionRelationship objects pre-filled with all related objects except AcquisitionRelatedByObjectId.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AcquisitionRelationship objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptAcquisitionRelatedByObjectId(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AcquisitionRelationshipPeer::DATABASE_NAME);
        }

        AcquisitionRelationshipPeer::addSelectColumns($criteria);
        $startcol2 = AcquisitionRelationshipPeer::NUM_HYDRATE_COLUMNS;

        CvtermPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + CvtermPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(AcquisitionRelationshipPeer::TYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AcquisitionRelationshipPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AcquisitionRelationshipPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = AcquisitionRelationshipPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AcquisitionRelationshipPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Cvterm rows

                $key2 = CvtermPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = CvtermPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = CvtermPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    CvtermPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (AcquisitionRelationship) to the collection in $obj2 (Cvterm)
                $obj2->addAcquisitionRelationship($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of AcquisitionRelationship objects pre-filled with all related objects except AcquisitionRelatedBySubjectId.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AcquisitionRelationship objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptAcquisitionRelatedBySubjectId(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AcquisitionRelationshipPeer::DATABASE_NAME);
        }

        AcquisitionRelationshipPeer::addSelectColumns($criteria);
        $startcol2 = AcquisitionRelationshipPeer::NUM_HYDRATE_COLUMNS;

        CvtermPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + CvtermPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(AcquisitionRelationshipPeer::TYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AcquisitionRelationshipPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AcquisitionRelationshipPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = AcquisitionRelationshipPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AcquisitionRelationshipPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Cvterm rows

                $key2 = CvtermPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = CvtermPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = CvtermPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    CvtermPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (AcquisitionRelationship) to the collection in $obj2 (Cvterm)
                $obj2->addAcquisitionRelationship($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of AcquisitionRelationship objects pre-filled with all related objects except Cvterm.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AcquisitionRelationship objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptCvterm(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AcquisitionRelationshipPeer::DATABASE_NAME);
        }

        AcquisitionRelationshipPeer::addSelectColumns($criteria);
        $startcol2 = AcquisitionRelationshipPeer::NUM_HYDRATE_COLUMNS;

        AcquisitionPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AcquisitionPeer::NUM_HYDRATE_COLUMNS;

        AcquisitionPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + AcquisitionPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(AcquisitionRelationshipPeer::OBJECT_ID, AcquisitionPeer::ACQUISITION_ID, $join_behavior);

        $criteria->addJoin(AcquisitionRelationshipPeer::SUBJECT_ID, AcquisitionPeer::ACQUISITION_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AcquisitionRelationshipPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AcquisitionRelationshipPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = AcquisitionRelationshipPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AcquisitionRelationshipPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Acquisition rows

                $key2 = AcquisitionPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = AcquisitionPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = AcquisitionPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AcquisitionPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (AcquisitionRelationship) to the collection in $obj2 (Acquisition)
                $obj2->addAcquisitionRelationshipRelatedByObjectId($obj1);

            } // if joined row is not null

                // Add objects for joined Acquisition rows

                $key3 = AcquisitionPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = AcquisitionPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = AcquisitionPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    AcquisitionPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (AcquisitionRelationship) to the collection in $obj3 (Acquisition)
                $obj3->addAcquisitionRelationshipRelatedBySubjectId($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }

    /**
     * Returns the TableMap related to this peer.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getDatabaseMap(AcquisitionRelationshipPeer::DATABASE_NAME)->getTable(AcquisitionRelationshipPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseAcquisitionRelationshipPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseAcquisitionRelationshipPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new AcquisitionRelationshipTableMap());
      }
    }

    /**
     * The class that the Peer will make instances of.
     *
     *
     * @return string ClassName
     */
    public static function getOMClass($row = 0, $colnum = 0)
    {
        return AcquisitionRelationshipPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a AcquisitionRelationship or Criteria object.
     *
     * @param      mixed $values Criteria or AcquisitionRelationship object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AcquisitionRelationshipPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from AcquisitionRelationship object
        }

        if ($criteria->containsKey(AcquisitionRelationshipPeer::ACQUISITION_RELATIONSHIP_ID) && $criteria->keyContainsValue(AcquisitionRelationshipPeer::ACQUISITION_RELATIONSHIP_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.AcquisitionRelationshipPeer::ACQUISITION_RELATIONSHIP_ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(AcquisitionRelationshipPeer::DATABASE_NAME);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = BasePeer::doInsert($criteria, $con);
            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

    /**
     * Performs an UPDATE on the database, given a AcquisitionRelationship or Criteria object.
     *
     * @param      mixed $values Criteria or AcquisitionRelationship object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AcquisitionRelationshipPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(AcquisitionRelationshipPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(AcquisitionRelationshipPeer::ACQUISITION_RELATIONSHIP_ID);
            $value = $criteria->remove(AcquisitionRelationshipPeer::ACQUISITION_RELATIONSHIP_ID);
            if ($value) {
                $selectCriteria->add(AcquisitionRelationshipPeer::ACQUISITION_RELATIONSHIP_ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(AcquisitionRelationshipPeer::TABLE_NAME);
            }

        } else { // $values is AcquisitionRelationship object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(AcquisitionRelationshipPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the acquisition_relationship table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AcquisitionRelationshipPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(AcquisitionRelationshipPeer::TABLE_NAME, $con, AcquisitionRelationshipPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AcquisitionRelationshipPeer::clearInstancePool();
            AcquisitionRelationshipPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a AcquisitionRelationship or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or AcquisitionRelationship object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param      PropelPDO $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *				if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, PropelPDO $con = null)
     {
        if ($con === null) {
            $con = Propel::getConnection(AcquisitionRelationshipPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            AcquisitionRelationshipPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof AcquisitionRelationship) { // it's a model object
            // invalidate the cache for this single object
            AcquisitionRelationshipPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AcquisitionRelationshipPeer::DATABASE_NAME);
            $criteria->add(AcquisitionRelationshipPeer::ACQUISITION_RELATIONSHIP_ID, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                AcquisitionRelationshipPeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(AcquisitionRelationshipPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            AcquisitionRelationshipPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given AcquisitionRelationship object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param      AcquisitionRelationship $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(AcquisitionRelationshipPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(AcquisitionRelationshipPeer::TABLE_NAME);

            if (! is_array($cols)) {
                $cols = array($cols);
            }

            foreach ($cols as $colName) {
                if ($tableMap->hasColumn($colName)) {
                    $get = 'get' . $tableMap->getColumn($colName)->getPhpName();
                    $columns[$colName] = $obj->$get();
                }
            }
        } else {

        }

        return BasePeer::doValidate(AcquisitionRelationshipPeer::DATABASE_NAME, AcquisitionRelationshipPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param      int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return AcquisitionRelationship
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = AcquisitionRelationshipPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(AcquisitionRelationshipPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(AcquisitionRelationshipPeer::DATABASE_NAME);
        $criteria->add(AcquisitionRelationshipPeer::ACQUISITION_RELATIONSHIP_ID, $pk);

        $v = AcquisitionRelationshipPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return AcquisitionRelationship[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AcquisitionRelationshipPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(AcquisitionRelationshipPeer::DATABASE_NAME);
            $criteria->add(AcquisitionRelationshipPeer::ACQUISITION_RELATIONSHIP_ID, $pks, Criteria::IN);
            $objs = AcquisitionRelationshipPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseAcquisitionRelationshipPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseAcquisitionRelationshipPeer::buildTableMap();

