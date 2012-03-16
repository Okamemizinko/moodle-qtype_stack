<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Stack question type upgrade code.
 *
 * @package    qtype_stack
 * @copyright  2012 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();


/**
 * Upgrade code for the Stack question type.
 * @param int $oldversion the version we are upgrading from.
 */
function xmldb_qtype_stack_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2012030300) {

        // Define table qtype_stack_cas_cache to be created
        $table = new xmldb_table('qtype_stack_cas_cache');

        // Adding fields to table qtype_stack_cas_cache
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('hash', XMLDB_TYPE_CHAR, '40', null, XMLDB_NOTNULL, null, null);
        $table->add_field('command', XMLDB_TYPE_TEXT, 'medium', null, XMLDB_NOTNULL, null, null);
        $table->add_field('result', XMLDB_TYPE_TEXT, 'medium', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table qtype_stack_cas_cache
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Adding indexes to table qtype_stack_cas_cache
        $table->add_index('hash', XMLDB_INDEX_UNIQUE, array('hash'));

        // Conditionally launch create table for qtype_stack_cas_cache
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // stack savepoint reached
        upgrade_plugin_savepoint(true, 2012030300, 'qtype', 'stack');
    }

    if ($oldversion < 2012030900) {

        // Define table qtype_stack to be created
        $table = new xmldb_table('qtype_stack');

        // Adding fields to table qtype_stack
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('questionid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('questionvariables', XMLDB_TYPE_TEXT, 'small', null, XMLDB_NOTNULL, null, null);
        $table->add_field('specificfeedback', XMLDB_TYPE_TEXT, 'small', null, XMLDB_NOTNULL, null, null);
        $table->add_field('specificfeedbackformat', XMLDB_TYPE_INTEGER, '2', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('questionnote', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null);
        $table->add_field('questionsimplify', XMLDB_TYPE_INTEGER, '4', null, XMLDB_NOTNULL, null, '1');
        $table->add_field('assumepositive', XMLDB_TYPE_INTEGER, '4', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('markmode', XMLDB_TYPE_CHAR, '16', null, XMLDB_NOTNULL, null, 'penalty');
        $table->add_field('prtcorrect', XMLDB_TYPE_TEXT, 'small', null, XMLDB_NOTNULL, null, null);
        $table->add_field('prtcorrectformat', XMLDB_TYPE_INTEGER, '2', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('prtpartiallycorrect', XMLDB_TYPE_TEXT, 'small', null, XMLDB_NOTNULL, null, null);
        $table->add_field('prtpartiallycorrectformat', XMLDB_TYPE_INTEGER, '2', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('prtincorrect', XMLDB_TYPE_TEXT, 'small', null, XMLDB_NOTNULL, null, null);
        $table->add_field('prtincorrectformat', XMLDB_TYPE_INTEGER, '2', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('multiplicationsign', XMLDB_TYPE_CHAR, '8', null, XMLDB_NOTNULL, null, 'dot');
        $table->add_field('sqrtsign', XMLDB_TYPE_INTEGER, '4', null, XMLDB_NOTNULL, null, '1');
        $table->add_field('complexno', XMLDB_TYPE_CHAR, '8', null, XMLDB_NOTNULL, null, 'i');

        // Adding keys to table qtype_stack
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        $table->add_key('questionid', XMLDB_KEY_FOREIGN_UNIQUE, array('questionid'), 'question', array('id'));

        // Conditionally launch create table for qtype_stack
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // stack savepoint reached
        upgrade_plugin_savepoint(true, 2012030900, 'qtype', 'stack');
    }

    if ($oldversion < 2012030901) {

        // Define table qtype_stack_inputs to be created
        $table = new xmldb_table('qtype_stack_inputs');

        // Adding fields to table qtype_stack_inputs
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('questionid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '32', null, XMLDB_NOTNULL, null, null);
        $table->add_field('type', XMLDB_TYPE_CHAR, '32', null, XMLDB_NOTNULL, null, null);
        $table->add_field('tans', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null);
        $table->add_field('boxsize', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '15');
        $table->add_field('strictsyntax', XMLDB_TYPE_INTEGER, '4', null, XMLDB_NOTNULL, null, '1');
        $table->add_field('insertstars', XMLDB_TYPE_INTEGER, '4', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('syntaxhint', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null);
        $table->add_field('forbidfloat', XMLDB_TYPE_INTEGER, '4', null, XMLDB_NOTNULL, null, '1');
        $table->add_field('requirelowestterms', XMLDB_TYPE_INTEGER, '4', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('checkanswertype', XMLDB_TYPE_INTEGER, '4', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('showvalidation', XMLDB_TYPE_INTEGER, '4', null, XMLDB_NOTNULL, null, '1');

        // Adding keys to table qtype_stack_inputs
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        $table->add_key('questionid', XMLDB_KEY_FOREIGN, array('questionid'), 'question', array('id'));

        // Adding indexes to table qtype_stack_inputs
        $table->add_index('questionid-name', XMLDB_INDEX_UNIQUE, array('questionid', 'name'));

        // Conditionally launch create table for qtype_stack_inputs
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // stack savepoint reached
        upgrade_plugin_savepoint(true, 2012030901, 'qtype', 'stack');
    }

    if ($oldversion < 2012030902) {

        // Define table qtype_stack_prts to be created
        $table = new xmldb_table('qtype_stack_prts');

        // Adding fields to table qtype_stack_prts
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('questionid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '32', null, XMLDB_NOTNULL, null, null);
        $table->add_field('value', XMLDB_TYPE_NUMBER, '12, 7', null, XMLDB_NOTNULL, null, '1');
        $table->add_field('autosimplify', XMLDB_TYPE_INTEGER, '4', null, XMLDB_NOTNULL, null, '1');
        $table->add_field('feedbackvariables', XMLDB_TYPE_TEXT, 'small', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table qtype_stack_prts
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        $table->add_key('questionid', XMLDB_KEY_FOREIGN, array('questionid'), 'question', array('id'));
        $table->add_key('questionid-name', XMLDB_KEY_UNIQUE, array('questionid', 'name'));

        // Conditionally launch create table for qtype_stack_prts
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // stack savepoint reached
        upgrade_plugin_savepoint(true, 2012030902, 'qtype', 'stack');
    }

    if ($oldversion < 2012030903) {

        // Define table qtype_stack_prt_nodes to be created
        $table = new xmldb_table('qtype_stack_prt_nodes');

        // Adding fields to table qtype_stack_prt_nodes
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('questionid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('prtname', XMLDB_TYPE_CHAR, '32', null, XMLDB_NOTNULL, null, null);
        $table->add_field('nodename', XMLDB_TYPE_CHAR, '8', null, XMLDB_NOTNULL, null, null);
        $table->add_field('answertest', XMLDB_TYPE_CHAR, '32', null, XMLDB_NOTNULL, null, null);
        $table->add_field('sans', XMLDB_TYPE_CHAR, '32', null, XMLDB_NOTNULL, null, null);
        $table->add_field('tans', XMLDB_TYPE_CHAR, '32', null, XMLDB_NOTNULL, null, null);
        $table->add_field('testoptions', XMLDB_TYPE_CHAR, '32', null, XMLDB_NOTNULL, null, null);
        $table->add_field('quiet', XMLDB_TYPE_INTEGER, '4', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('truescoremode', XMLDB_TYPE_CHAR, '4', null, XMLDB_NOTNULL, null, '=');
        $table->add_field('truescore', XMLDB_TYPE_NUMBER, '12, 7', null, XMLDB_NOTNULL, null, '1');
        $table->add_field('truepenalty', XMLDB_TYPE_NUMBER, '12, 7', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('truenextnode', XMLDB_TYPE_CHAR, '8', null, null, null, null);
        $table->add_field('trueanswernote', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null);
        $table->add_field('truefeedback', XMLDB_TYPE_TEXT, 'small', null, XMLDB_NOTNULL, null, null);
        $table->add_field('truefeedbackformat', XMLDB_TYPE_INTEGER, '2', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('falsescoremode', XMLDB_TYPE_CHAR, '4', null, XMLDB_NOTNULL, null, '=');
        $table->add_field('falsescore', XMLDB_TYPE_NUMBER, '12, 7', null, null, null, '0');
        $table->add_field('falsepenalty', XMLDB_TYPE_NUMBER, '12, 7', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('falsenextnode', XMLDB_TYPE_CHAR, '8', null, null, null, null);
        $table->add_field('falseanswernote', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null);
        $table->add_field('falsefeedback', XMLDB_TYPE_TEXT, 'small', null, XMLDB_NOTNULL, null, null);
        $table->add_field('falsefeedbackformat', XMLDB_TYPE_INTEGER, '2', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table qtype_stack_prt_nodes
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        $table->add_key('questionid-name', XMLDB_KEY_FOREIGN_UNIQUE, array('questionid', 'prtname'), 'qtype_stack_prts', array('questionid', 'name'));

        // Adding indexes to table qtype_stack_prt_nodes
        $table->add_index('questionid-prtname-nodename', XMLDB_INDEX_UNIQUE, array('questionid', 'prtname', 'nodename'));

        // Conditionally launch create table for qtype_stack_prt_nodes
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // stack savepoint reached
        upgrade_plugin_savepoint(true, 2012030903, 'qtype', 'stack');
    }

    if ($oldversion < 2012031301) {
        // Define key questionid-name (foreign) to be dropped form qtype_stack_prt_nodes
        $table = new xmldb_table('qtype_stack_prt_nodes');
        $key = new xmldb_key('questionid-name', XMLDB_KEY_FOREIGN_UNIQUE, array('questionid', 'prtname'), 'qtype_stack_prts', array('questionid', 'name'));

        // Launch drop key questionid-name
        $dbman->drop_key($table, $key);

        // stack savepoint reached
        upgrade_plugin_savepoint(true, 2012031301, 'qtype', 'stack');
    }

    if ($oldversion < 2012031302) {

        // Define key questionid-name (foreign) to be added to qtype_stack_prt_nodes
        $table = new xmldb_table('qtype_stack_prt_nodes');
        $key = new xmldb_key('questionid-name', XMLDB_KEY_FOREIGN, array('questionid', 'prtname'), 'qtype_stack_prts', array('questionid', 'name'));

        // Launch add key questionid-name
        $dbman->add_key($table, $key);

        // stack savepoint reached
        upgrade_plugin_savepoint(true, 2012031302, 'qtype', 'stack');
    }

    if ($oldversion < 2012031600) {

        // Define field forbidwords to be added to qtype_stack_inputs
        $table = new xmldb_table('qtype_stack_inputs');
        $field = new xmldb_field('forbidwords', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null, 'syntaxhint');

        // Conditionally launch add field forbidwords
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // qtype_stack savepoint reached
        upgrade_plugin_savepoint(true, 2012031600, 'qtype', 'stack');
    }

    if ($oldversion < 2012031601) {

        // Define field mustverify to be added to qtype_stack_inputs
        $table = new xmldb_table('qtype_stack_inputs');
        $field = new xmldb_field('mustverify', XMLDB_TYPE_INTEGER, '4', null, XMLDB_NOTNULL, null, '1', 'checkanswertype');

        // Conditionally launch add field mustverify
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // qtype_stack savepoint reached
        upgrade_plugin_savepoint(true, 2012031601, 'qtype', 'stack');
    }

    return true;
}
