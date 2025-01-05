Feature:
    In order to display children with a treatment
    As an API consumer
    I want to have access to related treatment child data

    Background:
        Given there is a nursery structure with uuid "00000000-0000-0000-0000-000000000001"
        And a manager exists with user "manager@example.com" and password "password123"
        And I am authenticated as "manager@example.com" with password "password123"

    Scenario: I can create a treatment with dosages
        Given there is a child with uuid "00000000-0000-0000-0000-000000000001"
        And that child is linked to nursery structure with uuid "00000000-0000-0000-0000-000000000001"
        And there is a treatment with uuid "00000000-0000-0000-0000-000000000001"
        And that treatment has name Doliprane
        And that treatment has description "Si besoin"
        And that treatment has a created date "2024-10-13 00:00:00"
        And that treatment has a start date "2024-10-14 00:00:00"
        And that treatment has an end date "2024-10-24 00:00:00"
        And that treatment is linked to child with uuid "00000000-0000-0000-0000-000000000001"
        And that treatment has dosages:
            | dose  | dosingTime |
            | 50mg  | 08:00      |
            | 100mg | 12:00      |
            | 150mg | 16:00      |
        Then the treatment should have 3 dosages
        And the table treatment has 1 entry with the following values:
            | uuid        | 00000000-0000-0000-0000-000000000001 |
            | id          | not_null                             |
            | name        | Doliprane                            |
            | description | Si besoin                            |
            | created_at  | 2024-10-13 00:00:00                  |
            | start_at    | 2024-10-14 00:00:00                  |
            | start_at    | 2024-10-14 00:00:00                  |
            | end_at      | 2024-10-24 00:00:00                  |
            | child_id    | not_null                             |
        And the table dosage has 1 entries with the following values:
            | treatment_id | not_null |
            | dose         | 50mg     |
            | dosing_time  | 08:00:00 |
        And the table dosage has 1 entries with the following values:
            | treatment_id | not_null |
            | dose         | 100mg    |
            | dosing_time  | 12:00:00 |
        And the table dosage has 1 entries with the following values:
            | treatment_id | not_null |
            | dose         | 150mg    |
            | dosing_time  | 16:00:00 |

    Scenario: I can create a treatment without dosage
        Given there is a child with uuid "00000000-0000-0000-0000-000000000001"
        And that child is linked to nursery structure with uuid "00000000-0000-0000-0000-000000000001"
        And there is a treatment with uuid "00000000-0000-0000-0000-000000000001"
        And that treatment has name Doliprane
        And that treatment has description "Si besoin"
        And that treatment has a created date "2024-10-13 00:00:00"
        And that treatment has a start date "2024-10-14 00:00:00"
        And that treatment has an end date "2024-10-24 00:00:00"
        And that treatment is linked to child with uuid "00000000-0000-0000-0000-000000000001"
        Then the treatment should have 0 dosages

    Scenario: I can create a treatment without dosage when I create a child using POST children
        Given the request body is:
        """
        {
            "firstname": "Quentin",
            "lastname": "Lemoine",
            "birthday": "1993-06-17",
            "nurseryStructureUuid": "00000000-0000-0000-0000-000000000001",
            "treatments": [
                {
                    "name": "Doliprane",
                    "description": "si besoin",
                    "startAt": "2024-01-01 00:00:00",
                    "endAt": "2025-01-01 00:00:00"
                }
            ]
        }
        """
        And the "Content-Type" request header is "application/ld+json"
        When I request "/api/children" using HTTP POST
        Then the response code is 201
        And the response body contains JSON:
        """
        {
            "@context":"/api/contexts/Child",
            "@type":"Child",
            "firstname":"Quentin",
            "lastname":"Lemoine",
            "birthday":"1993-06-17T00:00:00+00:00",
            "treatments":[
                {
                    "@type":"TreatmentView",
                    "@id":"@variableType(string)",
                    "uuid":"@variableType(string)",
                    "childUuid":"@variableType(string)",
                    "name":"Doliprane",
                    "description":"si besoin",
                    "createdAt":"@variableType(string)",
                    "startAt":"2024-01-01T00:00:00+00:00",
                    "endAt":"2025-01-01T00:00:00+00:00",
                    "dosages":[]
                }
            ]
        }
        """

    Scenario: I can create a treatment with dosages when I create a child using POST children
        Given the request body is:
        """
        {
            "firstname": "Quentin",
            "lastname": "Lemoine",
            "birthday": "1993-06-17",
            "nurseryStructureUuid": "00000000-0000-0000-0000-000000000001",
            "treatments": [
                {
                    "name": "Doliprane",
                    "description": "si besoin",
                    "startAt": "2024-01-01 00:00:00",
                    "endAt": "2025-01-01 00:00:00",
                    "dosages": [
                        {
                            "dose": "50mg",
                            "dosingTime": "08:00"
                        },
                        {
                            "dose": "100mg",
                            "dosingTime": "16:00"
                        }
                    ]
                }
            ]
        }
        """
        And the "Content-Type" request header is "application/ld+json"
        When I request "/api/children" using HTTP POST
        Then the response code is 201
        And the response body contains JSON:
        """
        {
            "@context":"/api/contexts/Child",
            "@type":"Child",
            "firstname":"Quentin",
            "lastname":"Lemoine",
            "birthday":"1993-06-17T00:00:00+00:00",
            "treatments":[
                {
                    "@type":"TreatmentView",
                    "@id":"@variableType(string)",
                    "uuid":"@variableType(string)",
                    "childUuid":"@variableType(string)",
                    "name":"Doliprane",
                    "description":"si besoin",
                    "createdAt":"@variableType(string)",
                    "startAt":"2024-01-01T00:00:00+00:00",
                    "endAt":"2025-01-01T00:00:00+00:00",
                    "dosages":[
                        {
                            "@type": "DosageView",
                            "dose": "50mg",
                            "dosingTime": "08:00"
                        },
                        {
                            "@type": "DosageView",
                            "dose": "100mg",
                            "dosingTime": "16:00"
                        }
                    ]
                }
            ]
        }
        """

    Scenario: I can create several treatments without dosage when I create a child using POST children
        Given the request body is:
        """
        {
            "firstname": "Quentin",
            "lastname": "Lemoine",
            "birthday": "1993-06-17",
            "nurseryStructureUuid": "00000000-0000-0000-0000-000000000001",
            "treatments": [
                {
                    "name": "Doliprane",
                    "description": "si besoin",
                    "startAt": "2024-01-01 00:00:00",
                    "endAt": "2025-01-01 00:00:00"
                },
                {
                    "name": "Maxilase",
                    "description": "si besoin",
                    "startAt": "2024-01-01 00:00:00",
                    "endAt": "2025-01-01 00:00:00"
                }
            ]
        }
        """
        And the "Content-Type" request header is "application/ld+json"
        When I request "/api/children" using HTTP POST
        Then the response code is 201
        And the response body contains JSON:
        """
        {
            "@context":"/api/contexts/Child",
            "@type":"Child",
            "firstname":"Quentin",
            "lastname":"Lemoine",
            "birthday":"1993-06-17T00:00:00+00:00",
            "treatments":[
                {
                    "@type":"TreatmentView",
                    "@id":"@variableType(string)",
                    "uuid":"@variableType(string)",
                    "childUuid":"@variableType(string)",
                    "name":"Doliprane",
                    "description":"si besoin",
                    "createdAt":"@variableType(string)",
                    "startAt":"2024-01-01T00:00:00+00:00",
                    "endAt":"2025-01-01T00:00:00+00:00",
                    "dosages":[]
                },
                {
                    "@type":"TreatmentView",
                    "@id":"@variableType(string)",
                    "uuid":"@variableType(string)",
                    "childUuid":"@variableType(string)",
                    "name":"Maxilase",
                    "description":"si besoin",
                    "createdAt":"@variableType(string)",
                    "startAt":"2024-01-01T00:00:00+00:00",
                    "endAt":"2025-01-01T00:00:00+00:00",
                    "dosages":[]
                }
            ]
        }
        """

    Scenario: I can create several treatments with dosages when I create a child using POST children
        Given the request body is:
        """
        {
            "firstname": "Quentin",
            "lastname": "Lemoine",
            "birthday": "1993-06-17",
            "nurseryStructureUuid": "00000000-0000-0000-0000-000000000001",
            "treatments": [
                {
                    "name": "Doliprane",
                    "description": "si besoin",
                    "startAt": "2024-01-01 00:00:00",
                    "endAt": "2025-01-01 00:00:00",
                    "dosages": [
                        {
                            "dose": "50mg",
                            "dosingTime": "08:00"
                        },
                        {
                            "dose": "100mg",
                            "dosingTime": "16:00"
                        }
                    ]
                },
                {
                    "name": "Maxilase",
                    "description": "si besoin",
                    "startAt": "2024-01-01 00:00:00",
                    "endAt": "2025-01-01 00:00:00",
                    "dosages": [
                        {
                            "dose": "200mg",
                            "dosingTime": "09:00"
                        },
                        {
                            "dose": "300mg",
                            "dosingTime": "15:00"
                        }
                    ]
                }
            ]
        }
        """
        And the "Content-Type" request header is "application/ld+json"
        When I request "/api/children" using HTTP POST
        Then the response code is 201
        And the response body contains JSON:
        """
        {
            "@context":"/api/contexts/Child",
            "@type":"Child",
            "firstname":"Quentin",
            "lastname":"Lemoine",
            "birthday":"1993-06-17T00:00:00+00:00",
            "treatments":[
                {
                    "@type":"TreatmentView",
                    "@id":"@variableType(string)",
                    "uuid":"@variableType(string)",
                    "childUuid":"@variableType(string)",
                    "name":"Doliprane",
                    "description":"si besoin",
                    "createdAt":"@variableType(string)",
                    "startAt":"2024-01-01T00:00:00+00:00",
                    "endAt":"2025-01-01T00:00:00+00:00",
                    "dosages":[
                        {
                            "@type": "DosageView",
                            "dose": "50mg",
                            "dosingTime": "08:00"
                        },
                        {
                            "@type": "DosageView",
                            "dose": "100mg",
                            "dosingTime": "16:00"
                        }
                    ]
                },
                {
                    "@type":"TreatmentView",
                    "@id":"@variableType(string)",
                    "uuid":"@variableType(string)",
                    "childUuid":"@variableType(string)",
                    "name":"Maxilase",
                    "description":"si besoin",
                    "createdAt":"@variableType(string)",
                    "startAt":"2024-01-01T00:00:00+00:00",
                    "endAt":"2025-01-01T00:00:00+00:00",
                    "dosages":[
                        {
                            "@type": "DosageView",
                            "dose": "200mg",
                            "dosingTime": "09:00"
                        },
                        {
                            "@type": "DosageView",
                            "dose": "300mg",
                            "dosingTime": "15:00"
                        }
                    ]
                }
            ]
        }
        """

    Scenario: I can create a treatment without dosage when I modify a child using PUT children
        Given there is a child with uuid "00000000-0000-0000-0000-000000000001"
        And that child has firstname Quentin
        And that child has lastname Lemoine
        And that child has a created date "2024-10-13 00:00:00"
        And that child has an updated date "2024-10-13 12:00:00"
        And that child has a birthday on "1993-06-17"
        And that child is linked to nursery structure with uuid "00000000-0000-0000-0000-000000000001"
        Given the request body is:
        """
        {
            "firstname": "Elie",
            "lastname": "Lemoine",
            "birthday": "1994-06-17",
            "nurseryStructureUuid": "00000000-0000-0000-0000-000000000001",
            "treatments": [
                {
                    "name": "Doliprane",
                    "description": "si besoin",
                    "startAt": "2024-01-01 00:00:00",
                    "endAt": "2025-01-01 00:00:00"
                }
            ]
        }
        """
        And the "Content-Type" request header is "application/ld+json"
        When I request "/api/children/00000000-0000-0000-0000-000000000001" using HTTP PUT
        Then the response code is 200
        And the response body contains JSON:
        """
        {
           "@context":"/api/contexts/Child",
           "@id":"/api/children/00000000-0000-0000-0000-000000000001",
           "@type":"Child",
           "uuid":"00000000-0000-0000-0000-000000000001",
           "firstname":"Elie",
           "lastname":"Lemoine",
           "birthday":"1994-06-17T00:00:00+00:00",
           "nurseryStructure":"@variableType(object)",
           "createdAt":"2024-10-13T00:00:00+00:00",
           "updatedAt":"@variableType(string)",
           "customers":[],
           "treatments":[
              {
                 "@type":"TreatmentView",
                 "childUuid":"00000000-0000-0000-0000-000000000001",
                 "name":"Doliprane",
                 "description":"si besoin",
                 "createdAt":"@variableType(string)",
                 "startAt":"2024-01-01T00:00:00+00:00",
                 "endAt":"2025-01-01T00:00:00+00:00",
                 "dosages":[]
              }
           ]
        }
        """

    Scenario: I can create a treatment with dosages when I modify a child using PUT children
        Given there is a child with uuid "00000000-0000-0000-0000-000000000001"
        And that child has firstname Quentin
        And that child has lastname Lemoine
        And that child has a created date "2024-10-13 00:00:00"
        And that child has an updated date "2024-10-13 12:00:00"
        And that child has a birthday on "1993-06-17"
        And that child is linked to nursery structure with uuid "00000000-0000-0000-0000-000000000001"
        Given the request body is:
        """
        {
            "firstname": "Elie",
            "lastname": "Lemoine",
            "birthday": "1994-06-17",
            "nurseryStructureUuid": "00000000-0000-0000-0000-000000000001",
            "treatments": [
                {
                    "name": "Doliprane",
                    "description": "si besoin",
                    "startAt": "2024-01-01 00:00:00",
                    "endAt": "2025-01-01 00:00:00",
                    "dosages": [
                        {
                            "dose": "50mg",
                            "dosingTime": "08:00"
                        },
                        {
                            "dose": "150mg",
                            "dosingTime": "16:00"
                        }
                    ]
                }
            ]
        }
        """
        And the "Content-Type" request header is "application/ld+json"
        When I request "/api/children/00000000-0000-0000-0000-000000000001" using HTTP PUT
        Then the response code is 200
        And the response body contains JSON:
        """
        {
            "@context":"/api/contexts/Child",
            "@id":"/api/children/00000000-0000-0000-0000-000000000001",
            "@type":"Child",
            "uuid":"00000000-0000-0000-0000-000000000001",
            "firstname":"Elie",
            "lastname":"Lemoine",
            "birthday":"1994-06-17T00:00:00+00:00",
            "nurseryStructure":"@variableType(object)",
            "createdAt":"2024-10-13T00:00:00+00:00",
            "updatedAt":"@variableType(string)",
            "customers":[],
            "treatments":[
                {
                    "@type":"TreatmentView",
                    "childUuid":"00000000-0000-0000-0000-000000000001",
                    "name":"Doliprane",
                    "description":"si besoin",
                    "createdAt":"@variableType(string)",
                    "startAt":"2024-01-01T00:00:00+00:00",
                    "endAt":"2025-01-01T00:00:00+00:00",
                    "dosages":[
                         {
                             "@type":"DosageView",
                             "dose":"50mg",
                             "dosingTime":"08:00"
                         },
                         {
                             "@type":"DosageView",
                             "dose":"150mg",
                             "dosingTime":"16:00"
                         }
                    ]
                }
            ]
        }
        """

    Scenario: I can create several treatments without dosage when I modify a child using PUT children
        Given there is a child with uuid "00000000-0000-0000-0000-000000000001"
        And that child has firstname Quentin
        And that child has lastname Lemoine
        And that child has a created date "2024-10-13 00:00:00"
        And that child has an updated date "2024-10-13 12:00:00"
        And that child has a birthday on "1993-06-17"
        And that child is linked to nursery structure with uuid "00000000-0000-0000-0000-000000000001"
        Given the request body is:
        """
        {
            "firstname": "Elie",
            "lastname": "Lemoine",
            "birthday": "1994-06-17",
            "nurseryStructureUuid": "00000000-0000-0000-0000-000000000001",
            "treatments": [
                {
                    "name": "Doliprane",
                    "description": "si besoin",
                    "startAt": "2024-01-01 00:00:00",
                    "endAt": "2025-01-01 00:00:00"
                },
                {
                    "name": "Maxilase",
                    "description": "si besoin",
                    "startAt": "2024-01-01 00:00:00",
                    "endAt": "2025-01-01 00:00:00"
                }
            ]
        }
        """
        And the "Content-Type" request header is "application/ld+json"
        When I request "/api/children/00000000-0000-0000-0000-000000000001" using HTTP PUT
        Then the response code is 200
        And the response body contains JSON:
        """
        {
            "@context":"/api/contexts/Child",
            "@id":"/api/children/00000000-0000-0000-0000-000000000001",
            "@type":"Child",
            "uuid":"00000000-0000-0000-0000-000000000001",
            "firstname":"Elie",
            "lastname":"Lemoine",
            "birthday":"1994-06-17T00:00:00+00:00",
            "nurseryStructure":"@variableType(object)",
            "createdAt":"2024-10-13T00:00:00+00:00",
            "updatedAt":"@variableType(string)",
            "customers":[],
            "treatments":[
                {
                    "@type":"TreatmentView",
                    "@id":"@variableType(string)",
                    "uuid":"@variableType(string)",
                    "childUuid":"@variableType(string)",
                    "name":"Doliprane",
                    "description":"si besoin",
                    "createdAt":"@variableType(string)",
                    "startAt":"2024-01-01T00:00:00+00:00",
                    "endAt":"2025-01-01T00:00:00+00:00",
                    "dosages":[]
                },
                {
                    "@type":"TreatmentView",
                    "@id":"@variableType(string)",
                    "uuid":"@variableType(string)",
                    "childUuid":"@variableType(string)",
                    "name":"Maxilase",
                    "description":"si besoin",
                    "createdAt":"@variableType(string)",
                    "startAt":"2024-01-01T00:00:00+00:00",
                    "endAt":"2025-01-01T00:00:00+00:00",
                    "dosages":[]
                }
            ]
        }
        """

    Scenario: I can create several treatments with dosages when I modify a child using PUT children
        Given there is a child with uuid "00000000-0000-0000-0000-000000000001"
        And that child has firstname Quentin
        And that child has lastname Lemoine
        And that child has a created date "2024-10-13 00:00:00"
        And that child has an updated date "2024-10-13 12:00:00"
        And that child has a birthday on "1993-06-17"
        And that child is linked to nursery structure with uuid "00000000-0000-0000-0000-000000000001"
        Given the request body is:
        """
        {
            "firstname": "Elie",
            "lastname": "Lemoine",
            "birthday": "1994-06-17",
            "nurseryStructureUuid": "00000000-0000-0000-0000-000000000001",
            "treatments": [
                {
                    "name": "Doliprane",
                    "description": "si besoin",
                    "startAt": "2024-01-01 00:00:00",
                    "endAt": "2025-01-01 00:00:00",
                    "dosages": [
                        {
                            "dose": "50mg",
                            "dosingTime": "08:00"
                        },
                        {
                            "dose": "150mg",
                            "dosingTime": "16:00"
                        }
                    ]
                },
                {
                    "name": "Maxilase",
                    "description": "si besoin",
                    "startAt": "2024-01-01 00:00:00",
                    "endAt": "2025-01-01 00:00:00",
                    "dosages": [
                        {
                            "dose": "100mg",
                            "dosingTime": "09:00"
                        },
                        {
                            "dose": "200mg",
                            "dosingTime": "15:00"
                        }
                    ]
                }
            ]
        }
        """
        And the "Content-Type" request header is "application/ld+json"
        When I request "/api/children/00000000-0000-0000-0000-000000000001" using HTTP PUT
        Then the response code is 200
        And the response body contains JSON:
        """
        {
            "@context":"/api/contexts/Child",
            "@id":"/api/children/00000000-0000-0000-0000-000000000001",
            "@type":"Child",
            "uuid":"00000000-0000-0000-0000-000000000001",
            "firstname":"Elie",
            "lastname":"Lemoine",
            "birthday":"1994-06-17T00:00:00+00:00",
            "nurseryStructure":"@variableType(object)",
            "createdAt":"2024-10-13T00:00:00+00:00",
            "updatedAt":"@variableType(string)",
            "customers":[],
            "treatments":[
                {
                    "@type":"TreatmentView",
                    "@id":"@variableType(string)",
                    "uuid":"@variableType(string)",
                    "childUuid":"@variableType(string)",
                    "name":"Doliprane",
                    "description":"si besoin",
                    "createdAt":"@variableType(string)",
                    "startAt":"2024-01-01T00:00:00+00:00",
                    "endAt":"2025-01-01T00:00:00+00:00",
                    "dosages":[
                         {
                             "@type":"DosageView",
                             "dose":"50mg",
                             "dosingTime":"08:00"
                         },
                         {
                             "@type":"DosageView",
                             "dose":"150mg",
                             "dosingTime":"16:00"
                         }
                    ]
                },
                {
                    "@type":"TreatmentView",
                    "@id":"@variableType(string)",
                    "uuid":"@variableType(string)",
                    "childUuid":"@variableType(string)",
                    "name":"Maxilase",
                    "description":"si besoin",
                    "createdAt":"@variableType(string)",
                    "startAt":"2024-01-01T00:00:00+00:00",
                    "endAt":"2025-01-01T00:00:00+00:00",
                    "dosages":[
                         {
                             "@type":"DosageView",
                             "dose":"100mg",
                             "dosingTime":"09:00"
                         },
                         {
                             "@type":"DosageView",
                             "dose":"200mg",
                             "dosingTime":"15:00"
                         }
                    ]
                }
            ]
        }
        """

    Scenario: I can remove a treatment when I modify a child using PUT children
        Given there is a child with uuid "00000000-0000-0000-0000-000000000001"
        And that child has firstname Quentin
        And that child has lastname Lemoine
        And that child has a created date "2024-10-13 00:00:00"
        And that child has an updated date "2024-10-13 12:00:00"
        And that child has a birthday on "1993-06-17"
        And that child is linked to nursery structure with uuid "00000000-0000-0000-0000-000000000001"
        And there is a treatment with uuid "00000000-0000-0000-0000-000000000001"
        And that treatment has name Doliprane
        And that treatment has description 'Si besoin'
        And that treatment has a created date "2024-10-13 00:00:00"
        And that treatment has a start date "2024-10-13 12:00:00"
        And that treatment has an end date "2025-10-13 12:00:00"
        And that treatment is linked to child with uuid "00000000-0000-0000-0000-000000000001"
        And that treatment has dosages:
            | dose  | dosingTime |
            | 50mg  | 08:00      |
            | 100mg | 12:00      |
            | 150mg | 16:00      |
        Then the treatment should have 3 dosages
            Given the request body is:
        """
        {
            "firstname": "Elie",
            "lastname": "Lemoine",
            "birthday": "1994-06-17",
            "nurseryStructureUuid": "00000000-0000-0000-0000-000000000001"
        }
        """
        And the "Content-Type" request header is "application/ld+json"
        When I request "/api/children/00000000-0000-0000-0000-000000000001" using HTTP PUT
        Then the response code is 200
        And the response body contains JSON:
        """
        {
           "@context":"/api/contexts/Child",
           "@id":"/api/children/00000000-0000-0000-0000-000000000001",
           "@type":"Child",
           "uuid":"00000000-0000-0000-0000-000000000001",
           "firstname":"Elie",
           "lastname":"Lemoine",
           "birthday":"1994-06-17T00:00:00+00:00",
           "nurseryStructure":"@variableType(object)",
           "createdAt":"2024-10-13T00:00:00+00:00",
           "updatedAt":"@variableType(string)",
           "customers":[],
           "treatments":[]
        }
        """
        And the table treatment has no entry with the following values:
            | uuid | 00000000-0000-0000-0000-000000000001 |
        And the table dosage has no entry with the following values:
            | treatment_id | not_null |

    Scenario: I can remove the correct treatment among others when I modify a child using PUT children
        Given there is a child with uuid "00000000-0000-0000-0000-000000000001"
        And that child has firstname Quentin
        And that child has lastname Lemoine
        And that child has a created date "2024-10-13 00:00:00"
        And that child has an updated date "2024-10-13 12:00:00"
        And that child has a birthday on "1993-06-17"
        And that child is linked to nursery structure with uuid "00000000-0000-0000-0000-000000000001"
        And there is a treatment with uuid "00000000-0000-0000-0000-000000000001"
        And that treatment has name Doliprane
        And that treatment has description 'Si besoin'
        And that treatment has a created date "2024-10-13 00:00:00"
        And that treatment has a start date "2024-10-13 12:00:00"
        And that treatment has an end date "2025-10-13 12:00:00"
        And that treatment is linked to child with uuid "00000000-0000-0000-0000-000000000001"
        And that treatment has dosages:
            | dose  | dosingTime |
            | 50mg  | 08:00      |
            | 100mg | 12:00      |
            | 150mg | 16:00      |
        Then the treatment should have 3 dosages
        And there is a treatment with uuid "00000000-0000-0000-0000-000000000002"
        And that treatment has name Maxilase
        And that treatment has description 'Si besoin'
        And that treatment has a created date "2024-10-13 00:00:00"
        And that treatment has a start date "2024-10-13 12:00:00"
        And that treatment has an end date "2025-10-13 12:00:00"
        And that treatment is linked to child with uuid "00000000-0000-0000-0000-000000000001"
        And that treatment has dosages:
            | dose  | dosingTime |
            | 400mg | 09:00      |
            | 600mg | 13:00      |
            | 800mg | 17:00      |
        Then the treatment should have 3 dosages
        Given the request body is:
        """
        {
            "firstname": "Elie",
            "lastname": "Lemoine",
            "birthday": "1994-06-17",
            "nurseryStructureUuid": "00000000-0000-0000-0000-000000000001",
            "treatments": [
                {
                    "name": "Maxilase",
                    "description": "si besoin",
                    "startAt": "2024-01-01 00:00:00",
                    "endAt": "2025-01-01 00:00:00",
                    "dosages": [
                        {
                            "dose": "100mg",
                            "dosingTime": "09:00"
                        },
                        {
                            "dose": "200mg",
                            "dosingTime": "15:00"
                        }
                    ]
                }
            ]
        }
        """
        And the "Content-Type" request header is "application/ld+json"
        When I request "/api/children/00000000-0000-0000-0000-000000000001" using HTTP PUT
        Then the response code is 200
        And the response body contains JSON:
        """
        {
            "@context":"/api/contexts/Child",
            "@id":"/api/children/00000000-0000-0000-0000-000000000001",
            "@type":"Child",
            "uuid":"00000000-0000-0000-0000-000000000001",
            "firstname":"Elie",
            "lastname":"Lemoine",
            "birthday":"1994-06-17T00:00:00+00:00",
            "nurseryStructure":"@variableType(object)",
            "createdAt":"2024-10-13T00:00:00+00:00",
            "updatedAt":"@variableType(string)",
            "customers":[],
            "treatments":[
                {
                    "@type":"TreatmentView",
                    "@id":"@variableType(string)",
                    "uuid":"@variableType(string)",
                    "childUuid":"00000000-0000-0000-0000-000000000001",
                    "name":"Maxilase",
                    "description":"si besoin",
                    "createdAt":"@variableType(string)",
                    "startAt":"2024-01-01T00:00:00+00:00",
                    "endAt":"2025-01-01T00:00:00+00:00",
                    "dosages": [
                        {
                            "@type":"DosageView",
                            "@id":"@variableType(string)",
                            "dose": "100mg",
                            "dosingTime": "09:00"
                        },
                        {
                            "@type":"DosageView",
                            "@id":"@variableType(string)",
                            "dose": "200mg",
                            "dosingTime": "15:00"
                        }
                    ]
                }
            ]
        }
        """
        And the table treatment has no entry with the following values:
            | name        | Doliprane |
            | description | Si besoin |
        And the table dosage has no entry with the following values:
            | treatment_id | not_null |
            | dose         | 50mg     |
            | dosing_time  | 08:00:00 |
        And the table dosage has no entry with the following values:
            | treatment_id | not_null |
            | dose         | 100mg    |
            | dosing_time  | 12:00:00 |
        And the table dosage has no entry with the following values:
            | treatment_id | not_null |
            | dose         | 150mg    |
            | dosing_time  | 16:00:00 |
        And the table dosage has no entry with the following values:
            | treatment_id | not_null |
            | dose         | 400mg    |
            | dosing_time  | 09:00:00 |
        And the table dosage has no entry with the following values:
            | treatment_id | not_null |
            | dose         | 600mg    |
            | dosing_time  | 13:00:00 |
        And the table dosage has no entry with the following values:
            | treatment_id | not_null |
            | dose         | 800mg    |
            | dosing_time  | 17:00:00 |
        And the table treatment has 1 entry with the following values:
            | name        | Maxilase  |
            | description | Si besoin |
        And the table dosage has 1 entry with the following values:
            | treatment_id | not_null |
            | dose         | 100mg    |
            | dosing_time  | 09:00:00 |
        And the table dosage has 1 entry with the following values:
            | treatment_id | not_null |
            | dose         | 200mg    |
            | dosing_time  | 15:00:00 |

    Scenario: I can POST a treatment on a child
        Given there is a child with uuid "00000000-0000-0000-0000-000000000001"
        And that child has firstname Quentin
        And that child has lastname Lemoine
        And that child has a created date "2024-10-13 00:00:00"
        And that child has an updated date "2024-10-13 12:00:00"
        And that child has a birthday on "1993-06-17"
        And that child is linked to nursery structure with uuid "00000000-0000-0000-0000-000000000001"
        And the request body is:
        """
        {
            "name": "Maxilase",
            "description": "si besoin",
            "startAt": "2024-01-01 00:00:00",
            "endAt": "2025-01-01 00:00:00",
            "dosages": [
                {
                    "dose": "100mg",
                    "dosingTime": "09:00"
                },
                {
                    "dose": "200mg",
                    "dosingTime": "15:00"
                }
            ]
        }
        """
        And the "Content-Type" request header is "application/ld+json"
        When I request "/api/treatments?child_uuid=00000000-0000-0000-0000-000000000001" using HTTP POST
        Then the response code is 201
        And the response body contains JSON:
        """
        {
            "@context":"/api/contexts/Treatment",
            "@id":"@variableType(string)",
            "@type":"Treatment",
            "uuid":"@variableType(string)",
            "child":{
                "@type":"ChildView",
                "@id":"@variableType(string)",
                "uuid":"00000000-0000-0000-0000-000000000001",
                "firstname":"Quentin",
                "lastname":"Lemoine",
                "birthday":"1993-06-17T00:00:00+00:00",
                "createdAt":"2024-10-13T00:00:00+00:00"
            },
            "name":"Maxilase",
            "description":"si besoin",
            "createdAt":"@variableType(string)",
            "startAt":"2024-01-01T00:00:00+00:00",
            "endAt":"2025-01-01T00:00:00+00:00",
            "dosages":[
                {
                    "@type":"DosageView",
                    "@id":"@variableType(string)",
                    "dose":"100mg",
                    "dosingTime":"09:00"
                },
                {
                    "@type":"DosageView",
                    "@id":"@variableType(string)",
                    "dose":"200mg",
                    "dosingTime":"15:00"
                }
            ]
        }
        """

    Scenario: I can GET treatment with uuid and with GET collection and I can delete it
        Given there is a child with uuid "00000000-0000-0000-0000-000000000001"
        And that child has firstname Quentin
        And that child has lastname Lemoine
        And that child has a created date "2024-10-13 00:00:00"
        And that child has an updated date "2024-10-13 12:00:00"
        And that child has a birthday on "1993-06-17"
        And that child is linked to nursery structure with uuid "00000000-0000-0000-0000-000000000001"
        And there is a treatment with uuid "00000000-0000-0000-0000-000000000001"
        And that treatment has name Doliprane
        And that treatment has description 'Si besoin'
        And that treatment has a created date "2024-10-13 00:00:00"
        And that treatment has a start date "2024-10-13 12:00:00"
        And that treatment has an end date "2025-10-13 12:00:00"
        And that treatment is linked to child with uuid "00000000-0000-0000-0000-000000000001"
        And that treatment has dosages:
            | dose  | dosingTime |
            | 50mg  | 08:00      |
            | 100mg | 12:00      |
            | 150mg | 16:00      |
        Then the treatment should have 3 dosages
        When I request "/api/treatments/00000000-0000-0000-0000-000000000001"
        Then the response code is 200
        And the response body contains JSON:
        """
        {
           "@context":"/api/contexts/Treatment",
           "@id":"/api/treatments/00000000-0000-0000-0000-000000000001",
           "@type":"Treatment",
           "uuid":"00000000-0000-0000-0000-000000000001",
           "child":{
              "@type":"ChildView",
              "@id":"@variableType(string)",
              "uuid":"00000000-0000-0000-0000-000000000001",
              "firstname":"Quentin",
              "lastname":"Lemoine",
              "birthday":"1993-06-17T00:00:00+00:00",
              "createdAt":"2024-10-13T00:00:00+00:00"
           },
           "name":"Doliprane",
           "description":"Si besoin",
           "createdAt":"2024-10-13T00:00:00+00:00",
           "startAt":"2024-10-13T12:00:00+00:00",
           "endAt":"2025-10-13T12:00:00+00:00",
           "dosages":[
              {
                 "@type":"DosageView",
                 "@id":"@variableType(string)",
                 "dose":"50mg",
                 "dosingTime":"08:00"
              },
              {
                 "@type":"DosageView",
                 "@id":"@variableType(string)",
                 "dose":"100mg",
                 "dosingTime":"12:00"
              },
              {
                 "@type":"DosageView",
                 "@id":"@variableType(string)",
                 "dose":"150mg",
                 "dosingTime":"16:00"
              }
           ]
        }
        """
        When I request "/api/treatments?page=1"
        Then the response code is 200
        And the response body contains JSON:
        """
        {
           "@context":"/api/contexts/Treatment",
           "@id":"/api/treatments",
           "@type":"Collection",
           "totalItems":1,
           "member":[
              {
                 "@id":"/api/treatments/00000000-0000-0000-0000-000000000001",
                 "@type":"Treatment",
                 "uuid":"00000000-0000-0000-0000-000000000001",
                 "child":"@variableType(object)",
                 "name":"Doliprane",
                 "description":"Si besoin",
                 "createdAt":"2024-10-13T00:00:00+00:00",
                 "startAt":"2024-10-13T12:00:00+00:00",
                 "endAt":"2025-10-13T12:00:00+00:00",
                 "dosages":[
                    {
                       "@type":"DosageView",
                       "@id":"@variableType(string)",
                       "dose":"50mg",
                       "dosingTime":"08:00"
                    },
                    {
                       "@type":"DosageView",
                       "@id":"@variableType(string)",
                       "dose":"100mg",
                       "dosingTime":"12:00"
                    },
                    {
                       "@type":"DosageView",
                       "@id":"@variableType(string)",
                       "dose":"150mg",
                       "dosingTime":"16:00"
                    }
                 ]
              }
           ]
        }
        """
        When I request "/api/treatments/00000000-0000-0000-0000-000000000001" using HTTP DELETE
        Then the response code is 204