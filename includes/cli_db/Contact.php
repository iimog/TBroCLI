<?php
namespace cli_db;

require_once __DIR__ . '/AbstractTable.php';

class Contact extends AbstractTable {

    public static function getKeys() {
        return array( 
            'id' => array(
                'colname' => 'ContactId',
                'actions' => array(
                    'details' => 'required',
                    'update' => 'required',
                    'delete' => 'required',
                ),
                'description' => 'contact id'
            ),
            'name' => array(
                'colname' => 'Name',
                'actions' => array(
                    'insert' => 'required',
                    'update' => 'optional',
                ),
                'description' => 'name'
            ),
            'description' => array(
                'colname' => 'Description',
                'actions' => array(
                    'insert' => 'optional',
                    'update' => 'optional',
                ),
                'description' => 'description'
            ),
        );
    }

    public static function CLI_commandDescription() {
        return 'Manipulate the database contacts.';
    }

    public static function CLI_commandName() {
        return 'contact';
    }

    public static function CLI_longHelp() {
        
    }

    public static function getSubCommands() {
        return array('insert', 'update', 'delete', 'details', 'list');
    }

    public static function executeCommand($options, $command_name) {
        $keys = self::getKeys();
        switch ($command_name) {
            case 'insert':
                $contact = new \cli_db\propel\Contact();
                $contact->setName($options['name']);
                isset($options['description']) && $contact->setDescription($options['description']);
                $lines = $contact->save();
                printf("%d line(s) inserted.\n", $lines);
                break;
            case 'update':
                $q = new \cli_db\propel\ContactQuery();
                $contact = $q->findOneByContactId($options['id']);
                if ($contact == null) {
                    printf("No contact found for id %d.\n", $options['id']);
                    break;
                }
                isset($options['name']) && $contact->setName($options['name']);
                isset($options['description']) && $contact->setDescription($options['description']);
                $lines = $contact->save();
                printf("%d line(s) udpated.\n", $lines);
                break;
            case 'delete':
                $q = new \cli_db\propel\ContactQuery();
                $contact = $q->findOneByContactId($options['id']);
                if ($contact == null) {
                    printf("No contact found for id %d.\n", $options['id']);
                    break;
                }
                $contact->delete();
                printf("Contact with id %d deleted successfully.\n", $contact->getContactId());
                break;
            case 'details':
                $q = new \cli_db\propel\ContactQuery();
                $contact = $q->findOneByContactId($options['id']);
                if ($contact == null) {
                    printf("No contact found for id %d.\n", $options['id']);
                    break;
                }
                $results = self::prepareQueryResult(array($contact));
                self::printTable(array_keys($keys), $results);
                $references = array();
                foreach ($contact->getBiomaterials() as $biomat){
                    $references[] = array('Biomaterial', sprintf("Id: %s\nName: %s", $biomat->getBiomaterialId(), $biomat->getName()));
                }
                foreach ($contact->getAssays() as $assay){
                    $references[] = array('Assay', sprintf("Id: %s\nName: %s", $assay->getAssayId(), $assay->getName()));
                }
                foreach ($contact->getQuantifications() as $assay){
                    $references[] = array('Quantification', sprintf("Id: %s\nName: %s", $assay->getQuantificationId(), $assay->getName()));
                }
                if (count($references)>0){
                    print "referenced by other tables:\n";
                    self::printTable(array('Table','Row'), $references);
                }
                break;
            case 'list':
                $q = new \cli_db\propel\ContactQuery();
                $results = self::prepareQueryResult($q->find());
                self::printTable(array_keys($keys), $results);
                break;
        }
    }

}

?>
