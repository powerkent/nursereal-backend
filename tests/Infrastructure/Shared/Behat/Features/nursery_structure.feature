Feature:
    In order to display nursery structures
    As an API consumer
    I want to have access to related nursery structure data

    Background:
        Given there is a nursery structure with uuid "00000000-0000-0000-0000-000000000001"
        And an agent exists with user "agent@example.com" and password "password123"
        And I am authenticated as "agent@example.com" with password "password123"

    Scenario: I can create a nursery structure
        Given that nursery structure has name "my nursery structure"
        And that nursery structure has an address "1 rue de la creche" with zipcode 62580 and city "Arleux-en-Gohelle"
        And that nursery structure has a created date "2024-10-01 00:00:00"
        And that nursery structure has an updated date "2024-10-02 00:00:00"
        When I request "/api/nursery_structures?page=1"
        Then the response code is 200
        And the response body contains JSON:
        """
        {
            "@context": "/api/contexts/NurseryStructure",
            "@id": "/api/nursery_structures",
            "@type": "Collection",
            "totalItems": 1,
            "member": [
                {
                    "@id": "/api/nursery_structures/00000000-0000-0000-0000-000000000001",
                    "@type": "NurseryStructure",
                    "uuid": "00000000-0000-0000-0000-000000000001",
                    "id": "@variableType(integer)",
                    "name": "my nursery structure",
                    "address": {
                        "@type": "AddressView",
                        "@id": "@variableType(string)",
                        "address": "1 rue de la creche",
                        "zipcode": 62580,
                        "city": "Arleux-en-Gohelle"

                    },
                    "createdAt": "2024-10-01T00:00:00+00:00",
                    "updatedAt": "2024-10-02T00:00:00+00:00"
                }
            ]
        }
        """
        And the table nursery_structure has 1 entry with the following values:
            | uuid       | 00000000-0000-0000-0000-000000000001 |
            | id         | not_null                             |
            | name       | my nursery structure                 |
            | address_id | not_null                             |
            | created_at | 2024-10-01 00:00:00                  |
            | updated_at | 2024-10-02 00:00:00                  |
        And the table address has 1 entry with the following values:
            | address | 1 rue de la creche |
            | zipcode | 62580              |
            | city    | Arleux-en-Gohelle  |

    Scenario: I can create a new nursery structure
        Given there is a nursery structure with uuid "00000000-0000-0000-0000-000000000002"
        And that nursery structure has name "my new nursery structure"
        And that nursery structure has an address "2 rue de la creche" with zipcode 62580 and city "Arleux-en-Gohelle"
        And that nursery structure has a created date "2024-10-03 00:00:00"
        And that nursery structure has an updated date "2024-10-04 00:00:00"
        When I request "/api/nursery_structures?page=1"
        Then the response code is 200
        And the response body contains JSON:
        """
        {
            "@context": "\/api\/contexts\/NurseryStructure",
            "@id": "\/api\/nursery_structures",
            "@type": "Collection",
            "totalItems": 2,
            "member": [
                {
                    "@id": "\/api\/nursery_structures\/00000000-0000-0000-0000-000000000001",
                    "@type": "NurseryStructure",
                    "uuid": "00000000-0000-0000-0000-000000000001",
                    "id": "@variableType(integer)",
                    "name": "@variableType(string)",
                    "address": "@variableType(object)",
                    "createdAt": "@variableType(string)"
                },
                {
                    "@id": "\/api\/nursery_structures\/00000000-0000-0000-0000-000000000002",
                    "@type": "NurseryStructure",
                    "uuid": "00000000-0000-0000-0000-000000000002",
                    "id": "@variableType(integer)",
                    "name": "my new nursery structure",
                    "address": {
                        "@type": "AddressView",
                        "@id": "@variableType(string)",
                        "address": "2 rue de la creche",
                        "zipcode": 62580,
                        "city": "Arleux-en-Gohelle"

                    },
                    "createdAt": "2024-10-03T00:00:00+00:00",
                    "updatedAt": "2024-10-04T00:00:00+00:00"
                }
            ]
        }
        """
        And the table nursery_structure has 1 entry with the following values:
            | uuid       | 00000000-0000-0000-0000-000000000002 |
            | id         | not_null                             |
            | name       | my new nursery structure             |
            | address_id | not_null                             |
            | created_at | 2024-10-03 00:00:00                  |
            | updated_at | 2024-10-04 00:00:00                  |
        And the table address has 1 entry with the following values:
            | address | 2 rue de la creche |
            | zipcode | 62580              |
            | city    | Arleux-en-Gohelle  |

    Scenario: I can POST a new nursery structure
        Given a manager exists with user "manager@example.com" and password "password123"
        And I am authenticated as "manager@example.com" with password "password123"
        And the request body is:
        """
        {
            "name": "une creche",
            "address": {
                "address": "3 rue de la creche",
                "zipcode": 62580,
                "city": "Arleux-en-Gohelle"
            },
            "openings": [
                {
                    "openingHour": "08:30",
                    "closingHour": "19:30",
                    "openingDay": "Monday"
                },
                {
                    "openingHour": "08:30",
                    "closingHour": "19:30",
                    "openingDay": "Tuesday"
                },
                {
                    "openingHour": "08:30",
                    "closingHour": "19:30",
                    "openingDay": "Wednesday"
                },
                {
                    "openingHour": "08:30",
                    "closingHour": "19:30",
                    "openingDay": "Thursday"
                },
                {
                    "openingHour": "08:30",
                    "closingHour": "19:30",
                    "openingDay": "Friday"
                }
            ]
        }
        """
        And the "Content-Type" request header is "application/ld+json"
        When I request "/api/nursery_structures" using HTTP POST
        Then the response code is 201
        And the table nursery_structure has 1 entry with the following values:
            | uuid       | not_null           |
            | id         | not_null           |
            | name       | une creche         |
            | address_id | not_null           |
            | created_at | not_null           |
            | updated_at | null               |
        And the table nursery_structure_opening has 1 entry with the following values:
            | nursery_structure_id | not_null |
            | opening_hour         | 08:30:00 |
            | closing_hour         | 19:30:00 |
            | opening_day          | Monday   |
        And the table nursery_structure_opening has 1 entry with the following values:
            | nursery_structure_id | not_null |
            | opening_hour         | 08:30:00 |
            | closing_hour         | 19:30:00 |
            | opening_day          | Tuesday  |
        And the table nursery_structure_opening has 1 entry with the following values:
            | nursery_structure_id | not_null  |
            | opening_hour         | 08:30:00  |
            | closing_hour         | 19:30:00  |
            | opening_day          | Wednesday |
        And the table nursery_structure_opening has 1 entry with the following values:
            | nursery_structure_id | not_null |
            | opening_hour         | 08:30:00 |
            | closing_hour         | 19:30:00 |
            | opening_day          | Thursday |
        And the table nursery_structure_opening has 1 entry with the following values:
            | nursery_structure_id | not_null |
            | opening_hour         | 08:30:00 |
            | closing_hour         | 19:30:00 |
            | opening_day          | Friday   |
        And the table address has 1 entry with the following values:
            | id      | not_null           |
            | address | 3 rue de la creche |
            | zipcode | 62580              |
            | city    | Arleux-en-Gohelle  |

    Scenario: I can GET a nursery structure
        Given there is a nursery structure with uuid "00000000-0000-0000-0000-000000000003"
        And that nursery structure has name "my nursery structure"
        And that nursery structure has an address "1 rue de la creche" with zipcode 62580 and city "Arleux-en-Gohelle"
        And that nursery structure has a created date "2024-10-03 00:00:00"
        And that nursery structure has an updated date "2024-10-04 00:00:00"
        When I request "/api/nursery_structures/00000000-0000-0000-0000-000000000003"
        Then the response code is 200
        And the response body contains JSON:
        """
        {
            "@context": "/api/contexts/NurseryStructure",
            "@id": "/api/nursery_structures/00000000-0000-0000-0000-000000000003",
            "@type": "NurseryStructure",
            "uuid": "00000000-0000-0000-0000-000000000003",
            "id": "@variableType(integer)",
            "name": "my nursery structure",
            "address": {
                "@type": "AddressView",
                "@id": "@variableType(string)",
                "address": "1 rue de la creche",
                "zipcode": 62580,
                "city": "Arleux-en-Gohelle"

            },
            "createdAt": "2024-10-03T00:00:00+00:00",
            "updatedAt": "2024-10-04T00:00:00+00:00",
            "openings": [
                {
                    "@type": "NurseryStructureOpeningView",
                    "@id": "@variableType(string)",
                    "openingHour": "07:00",
                    "closingHour": "19:00",
                    "openingDay": "Monday"
                },
                {
                    "@type": "NurseryStructureOpeningView",
                    "@id": "@variableType(string)",
                    "openingHour": "07:00",
                    "closingHour": "19:00",
                    "openingDay": "Tuesday"
                },
                {
                    "@type": "NurseryStructureOpeningView",
                    "@id": "@variableType(string)",
                    "openingHour": "07:00",
                    "closingHour": "19:00",
                    "openingDay": "Wednesday"
                },
                {
                    "@type": "NurseryStructureOpeningView",
                    "@id": "@variableType(string)",
                    "openingHour": "07:00",
                    "closingHour": "19:00",
                    "openingDay": "Thursday"
                },
                {
                    "@type": "NurseryStructureOpeningView",
                    "@id": "@variableType(string)",
                    "openingHour": "07:00",
                    "closingHour": "19:00",
                    "openingDay": "Friday"
                }
            ],
            "agents": [],
            "children": []
        }
        """

    Scenario: I can put a nursery structure
        Given a manager exists with user "manager@example.com" and password "password123"
        And I am authenticated as "manager@example.com" with password "password123"
        And the request body is:
        """
        {
            "name": "une nouvelle creche",
            "address": {
                "address": "1 rue de la creche",
                "zipcode": 62580,
                "city": "Arleux-en-Gohelle"
            },
            "openings": [
                {
                    "openingHour": "08:30",
                    "closingHour": "19:30",
                    "openingDay": "Monday"
                },
                {
                    "openingHour": "08:30",
                    "closingHour": "19:30",
                    "openingDay": "Tuesday"
                },
                {
                    "openingHour": "08:30",
                    "closingHour": "19:30",
                    "openingDay": "Wednesday"
                },
                {
                    "openingHour": "08:30",
                    "closingHour": "19:30",
                    "openingDay": "Thursday"
                },
                {
                    "openingHour": "08:30",
                    "closingHour": "19:30",
                    "openingDay": "Friday"
                }
            ]
        }
        """
        And the "Content-Type" request header is "application/ld+json"
        When I request "/api/nursery_structures/00000000-0000-0000-0000-000000000001" using HTTP PUT
        Then the response code is 200
        And the response body contains JSON:
        """
        {
            "@context": "/api/contexts/NurseryStructure",
            "@id": "/api/nursery_structures/00000000-0000-0000-0000-000000000001",
            "@type": "NurseryStructure",
            "uuid": "00000000-0000-0000-0000-000000000001",
            "id": "@variableType(integer)",
            "name": "une nouvelle creche",
            "address": {
                "address": "1 rue de la creche",
                "zipcode": 62580,
                "city": "Arleux-en-Gohelle"
            },
            "createdAt": "@variableType(string)",
            "updatedAt": "@variableType(string)",
            "openings": [
                {
                    "@type": "NurseryStructureOpeningView",
                    "@id": "@variableType(string)",
                    "openingHour": "08:30",
                    "closingHour": "19:30",
                    "openingDay": "Monday"
                },
                {
                    "@type": "NurseryStructureOpeningView",
                    "@id": "@variableType(string)",
                    "openingHour": "08:30",
                    "closingHour": "19:30",
                    "openingDay": "Tuesday"
                },
                {
                    "@type": "NurseryStructureOpeningView",
                    "@id": "@variableType(string)",
                    "openingHour": "08:30",
                    "closingHour": "19:30",
                    "openingDay": "Wednesday"
                },
                {
                    "@type": "NurseryStructureOpeningView",
                    "@id": "@variableType(string)",
                    "openingHour": "08:30",
                    "closingHour": "19:30",
                    "openingDay": "Thursday"
                },
                {
                    "@type": "NurseryStructureOpeningView",
                    "@id": "@variableType(string)",
                    "openingHour": "08:30",
                    "closingHour": "19:30",
                    "openingDay": "Friday"
                }
            ],
            "agents": [
                {
                    "@type": "AgentView",
                    "@id": "@variableType(string)",
                    "uuid": "@variableType(string)",
                    "firstname": "@variableType(string)",
                    "lastname": "@variableType(string)",
                    "email": "@variableType(string)",
                    "user": "agent@example.com"
                },
                {
                    "@type": "AgentView",
                    "@id": "@variableType(string)",
                    "uuid": "@variableType(string)",
                    "firstname": "@variableType(string)",
                    "lastname": "@variableType(string)",
                    "email": "@variableType(string)",
                    "user": "manager@example.com"
                }
            ],
            "children": []
        }
        """
        And the table nursery_structure has 1 entry with the following values:
            | uuid       | 00000000-0000-0000-0000-000000000001 |
            | id         | not_null                             |
            | name       | une nouvelle creche                  |
            | address_id | not_null                             |
            | created_at | not_null                             |
            | updated_at | not_null                             |
        And the table nursery_structure_opening has 1 entry with the following values:
            | nursery_structure_id | not_null |
            | opening_hour         | 08:30:00 |
            | closing_hour         | 19:30:00 |
            | opening_day          | Monday   |
        And the table nursery_structure_opening has 1 entry with the following values:
            | nursery_structure_id | not_null |
            | opening_hour         | 08:30:00 |
            | closing_hour         | 19:30:00 |
            | opening_day          | Tuesday  |
        And the table nursery_structure_opening has 1 entry with the following values:
            | nursery_structure_id | not_null  |
            | opening_hour         | 08:30:00  |
            | closing_hour         | 19:30:00  |
            | opening_day          | Wednesday |
        And the table nursery_structure_opening has 1 entry with the following values:
            | nursery_structure_id | not_null |
            | opening_hour         | 08:30:00 |
            | closing_hour         | 19:30:00 |
            | opening_day          | Thursday |
        And the table nursery_structure_opening has 1 entry with the following values:
            | nursery_structure_id | not_null |
            | opening_hour         | 08:30:00 |
            | closing_hour         | 19:30:00 |
            | opening_day          | Friday   |
        And the table address has 1 entry with the following values:
            | address | 1 rue de la creche |
            | zipcode | 62580              |
            | city    | Arleux-en-Gohelle  |

    Scenario: I can delete a nursery structure
        Given a manager exists with user "manager@example.com" and password "password123"
        And I am authenticated as "manager@example.com" with password "password123"
        And that nursery structure has name "my nursery structure"
        And that nursery structure has an address "1 rue de la creche" with zipcode 62580 and city "Arleux-en-Gohelle"
        And that nursery structure has a created date "2024-10-01 00:00:00"
        And that nursery structure has an updated date "2024-10-02 00:00:00"
        When I request "/api/nursery_structures/00000000-0000-0000-0000-000000000001"
        Then the response code is 200
        When I request "/api/nursery_structures/00000000-0000-0000-0000-000000000001" using HTTP DELETE
        Then the response code is 204
        When I request "/api/nursery_structures/00000000-0000-0000-0000-000000000001"
        Then the response code is 404
        And the table nursery_structure has no entry with the following values:
            | uuid       | 00000000-0000-0000-0000-000000000001 |