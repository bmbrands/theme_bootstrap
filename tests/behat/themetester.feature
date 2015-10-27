# This file is part of Moodle - http://moodle.org/
#
# Moodle is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# Moodle is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
#
# Tests for Snap personal menu.
#
# @package    theme_snap
# @copyright  2015 Guy Thomas <gthomas@moodlerooms.com>
# @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later


@theme @theme_bootstrap 
Feature: When the moodle theme is set to bootstrap, can visit theme tester without errors being thrown

  Background:
    Given the following config values are set as admin:
      | theme | bootstrap |
    And I log in as "admin"

  @javascript
  Scenario: No warnings thrown from renderers
    Given I am on site homepage
    And I navigate to "Theme tester" node in "Site administration > Development"
    And I follow "Headings"
    And I should see "H1 Heading"
    And I should see "H2 Heading"
    And I should see "H3 Heading"
    And I should see "H4 Heading"
    And I should see "H5 Heading"
    And I should see "H6 Heading"
    And I follow "Back to index"

    And I follow "Common tags"
    And I follow "Back to index"
    
    And I follow "Lists"
    And I follow "Back to index"

    And I follow "Tables"
    And I follow "Back to index"

    And I follow "Form elements"
    And I follow "Back to index"

    And I follow "Moodle form elements"
    And I follow "Standard form elements"
    And I press "Submit button"
    And I follow "Back to moodle forms"
    And I follow "Grouped form elements"
    And I press "Save changes"
    And I follow "Back to moodle forms"
    And I follow "Back to index"

    And I follow "Moodle tab bar"
    And I follow "Back to index"

    And I follow "Paging bar"
    And I follow "Back to index"

    And I follow "Images"
    And I follow "Back to index"

    And I follow "Notifications"
    And I should see "This is an error notification" in the ".alert-danger" "css_element"
    And I should see "This is a success notification" in the ".alert-success" "css_element"
    And I should see "This is a standard notification" in the ".alert-info" "css_element"
    And I follow "Back to index"

    And I follow "Confirmation"
    And I press "Cancel"

    And I follow "Progress Bars"
    And I follow "Back to index"

    And I follow "Bootstrap CSS"
    And I follow "Back to index"

    And I follow "Bootstrap Components"
    And I follow "Back to index"

    And I follow "Bootstrap Javascript"
    And I follow "Back to index"

