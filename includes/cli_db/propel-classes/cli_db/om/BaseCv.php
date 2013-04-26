<?php

namespace cli_db\propel\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use cli_db\propel\Cv;
use cli_db\propel\CvPeer;
use cli_db\propel\CvQuery;
use cli_db\propel\Cvprop;
use cli_db\propel\CvpropQuery;
use cli_db\propel\Cvterm;
use cli_db\propel\CvtermQuery;
use cli_db\propel\Cvtermpath;
use cli_db\propel\CvtermpathQuery;

/**
 * Base class that represents a row from the 'cv' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseCv extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\CvPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        CvPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the cv_id field.
     * @var        int
     */
    protected $cv_id;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the definition field.
     * @var        string
     */
    protected $definition;

    /**
     * @var        PropelObjectCollection|Cvprop[] Collection to store aggregation of Cvprop objects.
     */
    protected $collCvprops;
    protected $collCvpropsPartial;

    /**
     * @var        PropelObjectCollection|Cvterm[] Collection to store aggregation of Cvterm objects.
     */
    protected $collCvterms;
    protected $collCvtermsPartial;

    /**
     * @var        PropelObjectCollection|Cvtermpath[] Collection to store aggregation of Cvtermpath objects.
     */
    protected $collCvtermpaths;
    protected $collCvtermpathsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * Flag to prevent endless clearAllReferences($deep=true) loop, if this object is referenced
     * @var        boolean
     */
    protected $alreadyInClearAllReferencesDeep = false;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $cvpropsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $cvtermsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $cvtermpathsScheduledForDeletion = null;

    /**
     * Get the [cv_id] column value.
     *
     * @return int
     */
    public function getCvId()
    {
        return $this->cv_id;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [definition] column value.
     *
     * @return string
     */
    public function getDefinition()
    {
        return $this->definition;
    }

    /**
     * Set the value of [cv_id] column.
     *
     * @param int $v new value
     * @return Cv The current object (for fluent API support)
     */
    public function setCvId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->cv_id !== $v) {
            $this->cv_id = $v;
            $this->modifiedColumns[] = CvPeer::CV_ID;
        }


        return $this;
    } // setCvId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return Cv The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = CvPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [definition] column.
     *
     * @param string $v new value
     * @return Cv The current object (for fluent API support)
     */
    public function setDefinition($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->definition !== $v) {
            $this->definition = $v;
            $this->modifiedColumns[] = CvPeer::DEFINITION;
        }


        return $this;
    } // setDefinition()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return true
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->cv_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->name = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->definition = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 3; // 3 = CvPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Cv object", $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {

    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param boolean $deep (optional) Whether to also de-associated any related objects.
     * @param PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(CvPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = CvPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collCvprops = null;

            $this->collCvterms = null;

            $this->collCvtermpaths = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param PropelPDO $con
     * @return void
     * @throws PropelException
     * @throws Exception
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(CvPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = CvQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(CvPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                CvPeer::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->cvpropsScheduledForDeletion !== null) {
                if (!$this->cvpropsScheduledForDeletion->isEmpty()) {
                    CvpropQuery::create()
                        ->filterByPrimaryKeys($this->cvpropsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->cvpropsScheduledForDeletion = null;
                }
            }

            if ($this->collCvprops !== null) {
                foreach ($this->collCvprops as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->cvtermsScheduledForDeletion !== null) {
                if (!$this->cvtermsScheduledForDeletion->isEmpty()) {
                    CvtermQuery::create()
                        ->filterByPrimaryKeys($this->cvtermsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->cvtermsScheduledForDeletion = null;
                }
            }

            if ($this->collCvterms !== null) {
                foreach ($this->collCvterms as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->cvtermpathsScheduledForDeletion !== null) {
                if (!$this->cvtermpathsScheduledForDeletion->isEmpty()) {
                    CvtermpathQuery::create()
                        ->filterByPrimaryKeys($this->cvtermpathsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->cvtermpathsScheduledForDeletion = null;
                }
            }

            if ($this->collCvtermpaths !== null) {
                foreach ($this->collCvtermpaths as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = CvPeer::CV_ID;
        if (null !== $this->cv_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CvPeer::CV_ID . ')');
        }
        if (null === $this->cv_id) {
            try {
                $stmt = $con->query("SELECT nextval('cv_cv_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->cv_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CvPeer::CV_ID)) {
            $modifiedColumns[':p' . $index++]  = '"cv_id"';
        }
        if ($this->isColumnModified(CvPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '"name"';
        }
        if ($this->isColumnModified(CvPeer::DEFINITION)) {
            $modifiedColumns[':p' . $index++]  = '"definition"';
        }

        $sql = sprintf(
            'INSERT INTO "cv" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"cv_id"':
                        $stmt->bindValue($identifier, $this->cv_id, PDO::PARAM_INT);
                        break;
                    case '"name"':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '"definition"':
                        $stmt->bindValue($identifier, $this->definition, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        }

        $this->validationFailures = $res;

        return false;
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggreagated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            if (($retval = CvPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collCvprops !== null) {
                    foreach ($this->collCvprops as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collCvterms !== null) {
                    foreach ($this->collCvterms as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collCvtermpaths !== null) {
                    foreach ($this->collCvtermpaths as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }


            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *               one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *               Defaults to BasePeer::TYPE_PHPNAME
     * @return mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = CvPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getCvId();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
                return $this->getDefinition();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                    Defaults to BasePeer::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Cv'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Cv'][$this->getPrimaryKey()] = true;
        $keys = CvPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getCvId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getDefinition(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->collCvprops) {
                $result['Cvprops'] = $this->collCvprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCvterms) {
                $result['Cvterms'] = $this->collCvterms->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCvtermpaths) {
                $result['Cvtermpaths'] = $this->collCvtermpaths->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name peer name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                     Defaults to BasePeer::TYPE_PHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = CvPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setCvId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setDefinition($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's BasePeer::TYPE_PHPNAME
     *
     * @param array  $arr     An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = CvPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setCvId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setDefinition($arr[$keys[2]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(CvPeer::DATABASE_NAME);

        if ($this->isColumnModified(CvPeer::CV_ID)) $criteria->add(CvPeer::CV_ID, $this->cv_id);
        if ($this->isColumnModified(CvPeer::NAME)) $criteria->add(CvPeer::NAME, $this->name);
        if ($this->isColumnModified(CvPeer::DEFINITION)) $criteria->add(CvPeer::DEFINITION, $this->definition);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(CvPeer::DATABASE_NAME);
        $criteria->add(CvPeer::CV_ID, $this->cv_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getCvId();
    }

    /**
     * Generic method to set the primary key (cv_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setCvId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getCvId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Cv (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setDefinition($this->getDefinition());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getCvprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCvprop($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCvterms() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCvterm($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCvtermpaths() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCvtermpath($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setCvId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return Cv Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return CvPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new CvPeer();
        }

        return self::$peer;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Cvprop' == $relationName) {
            $this->initCvprops();
        }
        if ('Cvterm' == $relationName) {
            $this->initCvterms();
        }
        if ('Cvtermpath' == $relationName) {
            $this->initCvtermpaths();
        }
    }

    /**
     * Clears out the collCvprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cv The current object (for fluent API support)
     * @see        addCvprops()
     */
    public function clearCvprops()
    {
        $this->collCvprops = null; // important to set this to null since that means it is uninitialized
        $this->collCvpropsPartial = null;

        return $this;
    }

    /**
     * reset is the collCvprops collection loaded partially
     *
     * @return void
     */
    public function resetPartialCvprops($v = true)
    {
        $this->collCvpropsPartial = $v;
    }

    /**
     * Initializes the collCvprops collection.
     *
     * By default this just sets the collCvprops collection to an empty array (like clearcollCvprops());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCvprops($overrideExisting = true)
    {
        if (null !== $this->collCvprops && !$overrideExisting) {
            return;
        }
        $this->collCvprops = new PropelObjectCollection();
        $this->collCvprops->setModel('Cvprop');
    }

    /**
     * Gets an array of Cvprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cv is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Cvprop[] List of Cvprop objects
     * @throws PropelException
     */
    public function getCvprops($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collCvpropsPartial && !$this->isNew();
        if (null === $this->collCvprops || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCvprops) {
                // return empty collection
                $this->initCvprops();
            } else {
                $collCvprops = CvpropQuery::create(null, $criteria)
                    ->filterByCv($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collCvpropsPartial && count($collCvprops)) {
                      $this->initCvprops(false);

                      foreach($collCvprops as $obj) {
                        if (false == $this->collCvprops->contains($obj)) {
                          $this->collCvprops->append($obj);
                        }
                      }

                      $this->collCvpropsPartial = true;
                    }

                    $collCvprops->getInternalIterator()->rewind();
                    return $collCvprops;
                }

                if($partial && $this->collCvprops) {
                    foreach($this->collCvprops as $obj) {
                        if($obj->isNew()) {
                            $collCvprops[] = $obj;
                        }
                    }
                }

                $this->collCvprops = $collCvprops;
                $this->collCvpropsPartial = false;
            }
        }

        return $this->collCvprops;
    }

    /**
     * Sets a collection of Cvprop objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $cvprops A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cv The current object (for fluent API support)
     */
    public function setCvprops(PropelCollection $cvprops, PropelPDO $con = null)
    {
        $cvpropsToDelete = $this->getCvprops(new Criteria(), $con)->diff($cvprops);

        $this->cvpropsScheduledForDeletion = unserialize(serialize($cvpropsToDelete));

        foreach ($cvpropsToDelete as $cvpropRemoved) {
            $cvpropRemoved->setCv(null);
        }

        $this->collCvprops = null;
        foreach ($cvprops as $cvprop) {
            $this->addCvprop($cvprop);
        }

        $this->collCvprops = $cvprops;
        $this->collCvpropsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Cvprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Cvprop objects.
     * @throws PropelException
     */
    public function countCvprops(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collCvpropsPartial && !$this->isNew();
        if (null === $this->collCvprops || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCvprops) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getCvprops());
            }
            $query = CvpropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCv($this)
                ->count($con);
        }

        return count($this->collCvprops);
    }

    /**
     * Method called to associate a Cvprop object to this object
     * through the Cvprop foreign key attribute.
     *
     * @param    Cvprop $l Cvprop
     * @return Cv The current object (for fluent API support)
     */
    public function addCvprop(Cvprop $l)
    {
        if ($this->collCvprops === null) {
            $this->initCvprops();
            $this->collCvpropsPartial = true;
        }
        if (!in_array($l, $this->collCvprops->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCvprop($l);
        }

        return $this;
    }

    /**
     * @param	Cvprop $cvprop The cvprop object to add.
     */
    protected function doAddCvprop($cvprop)
    {
        $this->collCvprops[]= $cvprop;
        $cvprop->setCv($this);
    }

    /**
     * @param	Cvprop $cvprop The cvprop object to remove.
     * @return Cv The current object (for fluent API support)
     */
    public function removeCvprop($cvprop)
    {
        if ($this->getCvprops()->contains($cvprop)) {
            $this->collCvprops->remove($this->collCvprops->search($cvprop));
            if (null === $this->cvpropsScheduledForDeletion) {
                $this->cvpropsScheduledForDeletion = clone $this->collCvprops;
                $this->cvpropsScheduledForDeletion->clear();
            }
            $this->cvpropsScheduledForDeletion[]= clone $cvprop;
            $cvprop->setCv(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cv is new, it will return
     * an empty collection; or if this Cv has previously
     * been saved, it will retrieve related Cvprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cv.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Cvprop[] List of Cvprop objects
     */
    public function getCvpropsJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = CvpropQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getCvprops($query, $con);
    }

    /**
     * Clears out the collCvterms collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cv The current object (for fluent API support)
     * @see        addCvterms()
     */
    public function clearCvterms()
    {
        $this->collCvterms = null; // important to set this to null since that means it is uninitialized
        $this->collCvtermsPartial = null;

        return $this;
    }

    /**
     * reset is the collCvterms collection loaded partially
     *
     * @return void
     */
    public function resetPartialCvterms($v = true)
    {
        $this->collCvtermsPartial = $v;
    }

    /**
     * Initializes the collCvterms collection.
     *
     * By default this just sets the collCvterms collection to an empty array (like clearcollCvterms());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCvterms($overrideExisting = true)
    {
        if (null !== $this->collCvterms && !$overrideExisting) {
            return;
        }
        $this->collCvterms = new PropelObjectCollection();
        $this->collCvterms->setModel('Cvterm');
    }

    /**
     * Gets an array of Cvterm objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cv is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Cvterm[] List of Cvterm objects
     * @throws PropelException
     */
    public function getCvterms($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collCvtermsPartial && !$this->isNew();
        if (null === $this->collCvterms || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCvterms) {
                // return empty collection
                $this->initCvterms();
            } else {
                $collCvterms = CvtermQuery::create(null, $criteria)
                    ->filterByCv($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collCvtermsPartial && count($collCvterms)) {
                      $this->initCvterms(false);

                      foreach($collCvterms as $obj) {
                        if (false == $this->collCvterms->contains($obj)) {
                          $this->collCvterms->append($obj);
                        }
                      }

                      $this->collCvtermsPartial = true;
                    }

                    $collCvterms->getInternalIterator()->rewind();
                    return $collCvterms;
                }

                if($partial && $this->collCvterms) {
                    foreach($this->collCvterms as $obj) {
                        if($obj->isNew()) {
                            $collCvterms[] = $obj;
                        }
                    }
                }

                $this->collCvterms = $collCvterms;
                $this->collCvtermsPartial = false;
            }
        }

        return $this->collCvterms;
    }

    /**
     * Sets a collection of Cvterm objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $cvterms A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cv The current object (for fluent API support)
     */
    public function setCvterms(PropelCollection $cvterms, PropelPDO $con = null)
    {
        $cvtermsToDelete = $this->getCvterms(new Criteria(), $con)->diff($cvterms);

        $this->cvtermsScheduledForDeletion = unserialize(serialize($cvtermsToDelete));

        foreach ($cvtermsToDelete as $cvtermRemoved) {
            $cvtermRemoved->setCv(null);
        }

        $this->collCvterms = null;
        foreach ($cvterms as $cvterm) {
            $this->addCvterm($cvterm);
        }

        $this->collCvterms = $cvterms;
        $this->collCvtermsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Cvterm objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Cvterm objects.
     * @throws PropelException
     */
    public function countCvterms(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collCvtermsPartial && !$this->isNew();
        if (null === $this->collCvterms || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCvterms) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getCvterms());
            }
            $query = CvtermQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCv($this)
                ->count($con);
        }

        return count($this->collCvterms);
    }

    /**
     * Method called to associate a Cvterm object to this object
     * through the Cvterm foreign key attribute.
     *
     * @param    Cvterm $l Cvterm
     * @return Cv The current object (for fluent API support)
     */
    public function addCvterm(Cvterm $l)
    {
        if ($this->collCvterms === null) {
            $this->initCvterms();
            $this->collCvtermsPartial = true;
        }
        if (!in_array($l, $this->collCvterms->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCvterm($l);
        }

        return $this;
    }

    /**
     * @param	Cvterm $cvterm The cvterm object to add.
     */
    protected function doAddCvterm($cvterm)
    {
        $this->collCvterms[]= $cvterm;
        $cvterm->setCv($this);
    }

    /**
     * @param	Cvterm $cvterm The cvterm object to remove.
     * @return Cv The current object (for fluent API support)
     */
    public function removeCvterm($cvterm)
    {
        if ($this->getCvterms()->contains($cvterm)) {
            $this->collCvterms->remove($this->collCvterms->search($cvterm));
            if (null === $this->cvtermsScheduledForDeletion) {
                $this->cvtermsScheduledForDeletion = clone $this->collCvterms;
                $this->cvtermsScheduledForDeletion->clear();
            }
            $this->cvtermsScheduledForDeletion[]= clone $cvterm;
            $cvterm->setCv(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cv is new, it will return
     * an empty collection; or if this Cv has previously
     * been saved, it will retrieve related Cvterms from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cv.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Cvterm[] List of Cvterm objects
     */
    public function getCvtermsJoinDbxref($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = CvtermQuery::create(null, $criteria);
        $query->joinWith('Dbxref', $join_behavior);

        return $this->getCvterms($query, $con);
    }

    /**
     * Clears out the collCvtermpaths collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cv The current object (for fluent API support)
     * @see        addCvtermpaths()
     */
    public function clearCvtermpaths()
    {
        $this->collCvtermpaths = null; // important to set this to null since that means it is uninitialized
        $this->collCvtermpathsPartial = null;

        return $this;
    }

    /**
     * reset is the collCvtermpaths collection loaded partially
     *
     * @return void
     */
    public function resetPartialCvtermpaths($v = true)
    {
        $this->collCvtermpathsPartial = $v;
    }

    /**
     * Initializes the collCvtermpaths collection.
     *
     * By default this just sets the collCvtermpaths collection to an empty array (like clearcollCvtermpaths());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCvtermpaths($overrideExisting = true)
    {
        if (null !== $this->collCvtermpaths && !$overrideExisting) {
            return;
        }
        $this->collCvtermpaths = new PropelObjectCollection();
        $this->collCvtermpaths->setModel('Cvtermpath');
    }

    /**
     * Gets an array of Cvtermpath objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cv is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Cvtermpath[] List of Cvtermpath objects
     * @throws PropelException
     */
    public function getCvtermpaths($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collCvtermpathsPartial && !$this->isNew();
        if (null === $this->collCvtermpaths || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCvtermpaths) {
                // return empty collection
                $this->initCvtermpaths();
            } else {
                $collCvtermpaths = CvtermpathQuery::create(null, $criteria)
                    ->filterByCv($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collCvtermpathsPartial && count($collCvtermpaths)) {
                      $this->initCvtermpaths(false);

                      foreach($collCvtermpaths as $obj) {
                        if (false == $this->collCvtermpaths->contains($obj)) {
                          $this->collCvtermpaths->append($obj);
                        }
                      }

                      $this->collCvtermpathsPartial = true;
                    }

                    $collCvtermpaths->getInternalIterator()->rewind();
                    return $collCvtermpaths;
                }

                if($partial && $this->collCvtermpaths) {
                    foreach($this->collCvtermpaths as $obj) {
                        if($obj->isNew()) {
                            $collCvtermpaths[] = $obj;
                        }
                    }
                }

                $this->collCvtermpaths = $collCvtermpaths;
                $this->collCvtermpathsPartial = false;
            }
        }

        return $this->collCvtermpaths;
    }

    /**
     * Sets a collection of Cvtermpath objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $cvtermpaths A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cv The current object (for fluent API support)
     */
    public function setCvtermpaths(PropelCollection $cvtermpaths, PropelPDO $con = null)
    {
        $cvtermpathsToDelete = $this->getCvtermpaths(new Criteria(), $con)->diff($cvtermpaths);

        $this->cvtermpathsScheduledForDeletion = unserialize(serialize($cvtermpathsToDelete));

        foreach ($cvtermpathsToDelete as $cvtermpathRemoved) {
            $cvtermpathRemoved->setCv(null);
        }

        $this->collCvtermpaths = null;
        foreach ($cvtermpaths as $cvtermpath) {
            $this->addCvtermpath($cvtermpath);
        }

        $this->collCvtermpaths = $cvtermpaths;
        $this->collCvtermpathsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Cvtermpath objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Cvtermpath objects.
     * @throws PropelException
     */
    public function countCvtermpaths(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collCvtermpathsPartial && !$this->isNew();
        if (null === $this->collCvtermpaths || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCvtermpaths) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getCvtermpaths());
            }
            $query = CvtermpathQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCv($this)
                ->count($con);
        }

        return count($this->collCvtermpaths);
    }

    /**
     * Method called to associate a Cvtermpath object to this object
     * through the Cvtermpath foreign key attribute.
     *
     * @param    Cvtermpath $l Cvtermpath
     * @return Cv The current object (for fluent API support)
     */
    public function addCvtermpath(Cvtermpath $l)
    {
        if ($this->collCvtermpaths === null) {
            $this->initCvtermpaths();
            $this->collCvtermpathsPartial = true;
        }
        if (!in_array($l, $this->collCvtermpaths->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCvtermpath($l);
        }

        return $this;
    }

    /**
     * @param	Cvtermpath $cvtermpath The cvtermpath object to add.
     */
    protected function doAddCvtermpath($cvtermpath)
    {
        $this->collCvtermpaths[]= $cvtermpath;
        $cvtermpath->setCv($this);
    }

    /**
     * @param	Cvtermpath $cvtermpath The cvtermpath object to remove.
     * @return Cv The current object (for fluent API support)
     */
    public function removeCvtermpath($cvtermpath)
    {
        if ($this->getCvtermpaths()->contains($cvtermpath)) {
            $this->collCvtermpaths->remove($this->collCvtermpaths->search($cvtermpath));
            if (null === $this->cvtermpathsScheduledForDeletion) {
                $this->cvtermpathsScheduledForDeletion = clone $this->collCvtermpaths;
                $this->cvtermpathsScheduledForDeletion->clear();
            }
            $this->cvtermpathsScheduledForDeletion[]= clone $cvtermpath;
            $cvtermpath->setCv(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cv is new, it will return
     * an empty collection; or if this Cv has previously
     * been saved, it will retrieve related Cvtermpaths from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cv.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Cvtermpath[] List of Cvtermpath objects
     */
    public function getCvtermpathsJoinCvtermRelatedByObjectId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = CvtermpathQuery::create(null, $criteria);
        $query->joinWith('CvtermRelatedByObjectId', $join_behavior);

        return $this->getCvtermpaths($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cv is new, it will return
     * an empty collection; or if this Cv has previously
     * been saved, it will retrieve related Cvtermpaths from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cv.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Cvtermpath[] List of Cvtermpath objects
     */
    public function getCvtermpathsJoinCvtermRelatedBySubjectId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = CvtermpathQuery::create(null, $criteria);
        $query->joinWith('CvtermRelatedBySubjectId', $join_behavior);

        return $this->getCvtermpaths($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cv is new, it will return
     * an empty collection; or if this Cv has previously
     * been saved, it will retrieve related Cvtermpaths from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cv.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Cvtermpath[] List of Cvtermpath objects
     */
    public function getCvtermpathsJoinCvtermRelatedByTypeId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = CvtermpathQuery::create(null, $criteria);
        $query->joinWith('CvtermRelatedByTypeId', $join_behavior);

        return $this->getCvtermpaths($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->cv_id = null;
        $this->name = null;
        $this->definition = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volumne/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep && !$this->alreadyInClearAllReferencesDeep) {
            $this->alreadyInClearAllReferencesDeep = true;
            if ($this->collCvprops) {
                foreach ($this->collCvprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCvterms) {
                foreach ($this->collCvterms as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCvtermpaths) {
                foreach ($this->collCvtermpaths as $o) {
                    $o->clearAllReferences($deep);
                }
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collCvprops instanceof PropelCollection) {
            $this->collCvprops->clearIterator();
        }
        $this->collCvprops = null;
        if ($this->collCvterms instanceof PropelCollection) {
            $this->collCvterms->clearIterator();
        }
        $this->collCvterms = null;
        if ($this->collCvtermpaths instanceof PropelCollection) {
            $this->collCvtermpaths->clearIterator();
        }
        $this->collCvtermpaths = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CvPeer::DEFAULT_STRING_FORMAT);
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

}
