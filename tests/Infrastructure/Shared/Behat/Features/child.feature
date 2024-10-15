Feature:
    In order to display children
    As an API consumer
    I want to have access to related child data

    Background:
        Given there is a nursery structure with uuid "00000000-0000-0000-0000-000000000001"
        And a manager exists with email "manager@example.com" and password "password123"
        And I am authenticated as "manager@example.com" with password "password123"

    Scenario: I can create a child
        Given there is a child with uuid "00000000-0000-0000-0000-000000000001"
        And that child has firstname Quentin
        And that child has lastname Lemoine
        And that child has a birthday on "1993-06-17"
        And that child has a created date "2024-10-11 00:00:00"
        And that child has an updated date "2024-10-11 12:00:00"
        When I request "/api/children?page=1"
        Then the response code is 200
        And the response body contains JSON:
        """
        {
            "@context": "/api/contexts/Child",
            "@id": "/api/children",
            "@type": "hydra:Collection",
            "hydra:totalItems": 1,
            "hydra:member": [
                {
                    "@id": "/api/children/00000000-0000-0000-0000-000000000001",
                    "@type": "Child",
                    "uuid": "00000000-0000-0000-0000-000000000001",
                    "id": "@variableType(integer)",
                    "firstname": "Quentin",
                    "lastname": "Lemoine",
                    "birthday": "1993-06-17T00:00:00+00:00",
                    "nurseryStructure": {
                        "@type": "NurseryStructureView",
                        "@id": "@variableType(string)",
                        "uuid": "00000000-0000-0000-0000-000000000001",
                        "id": "@variableType(integer)",
                        "name": "@variableType(string)",
                        "address": "@variableType(string)",
                        "createdAt": "@variableType(string)",
                        "opening": [
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
                        ]
                    },
                    "createdAt": "2024-10-11T00:00:00+00:00",
                    "updatedAt": "2024-10-11T12:00:00+00:00",
                    "customers": [],
                    "treatments": []
                }
            ]
        }
        """
        And the table child has 1 entry with the following values:
            | uuid                 | 00000000-0000-0000-0000-000000000001 |
            | id                   | not_null                             |
            | firstname            | Quentin                              |
            | lastname             | Lemoine                              |
            | irp                  | null                                 |
            | birthday             | 1993-06-17 00:00:00                  |
            | created_at           | 2024-10-11 00:00:00                  |
            | updated_at           | 2024-10-11 12:00:00                  |
            | nursery_structure_id | not_null                             |

    Scenario: I can POST a child
        Given the request body is:
        """
        {
          "firstname": "Quentin",
          "lastname": "Lemoine",
          "birthday": "1993-06-17",
          "nurseryStructureUuid": "00000000-0000-0000-0000-000000000001"
        }
        """
        And the "Content-Type" request header is "application/ld+json"
        When I request "/api/children" using HTTP POST
        Then the response code is 201
        And the response body contains JSON:
        """
        {
           "@context":"/api/contexts/Child",
           "@id":"@variableType(string)",
           "@type":"Child",
           "uuid":"@variableType(string)",
           "id":"@variableType(integer)",
           "firstname":"Quentin",
           "lastname":"Lemoine",
           "birthday":"1993-06-17T00:00:00+00:00",
           "nurseryStructure":{
              "@type":"NurseryStructureView",
              "@id":"@variableType(string)",
              "uuid":"00000000-0000-0000-0000-000000000001",
              "id":"@variableType(integer)",
              "name":"@variableType(string)",
              "address":"@variableType(string)",
              "createdAt":"@variableType(string)",
              "opening":[
                 {
                    "@type":"NurseryStructureOpeningView",
                    "@id":"@variableType(string)",
                    "openingHour":"07:00",
                    "closingHour":"19:00",
                    "openingDay":"Monday"
                 },
                 {
                    "@type":"NurseryStructureOpeningView",
                    "@id":"@variableType(string)",
                    "openingHour":"07:00",
                    "closingHour":"19:00",
                    "openingDay":"Tuesday"
                 },
                 {
                    "@type":"NurseryStructureOpeningView",
                    "@id":"@variableType(string)",
                    "openingHour":"07:00",
                    "closingHour":"19:00",
                    "openingDay":"Wednesday"
                 },
                 {
                    "@type":"NurseryStructureOpeningView",
                    "@id":"@variableType(string)",
                    "openingHour":"07:00",
                    "closingHour":"19:00",
                    "openingDay":"Thursday"
                 },
                 {
                    "@type":"NurseryStructureOpeningView",
                    "@id":"@variableType(string)",
                    "openingHour":"07:00",
                    "closingHour":"19:00",
                    "openingDay":"Friday"
                 }
              ]
           },
           "createdAt":"@variableType(string)",
           "customers":[],
           "treatments":[]
        }
        """
        And the table child has 1 entry with the following values:
            | uuid                 | not_null            |
            | id                   | not_null            |
            | firstname            | Quentin             |
            | lastname             | Lemoine             |
            | irp                  | null                |
            | birthday             | 1993-06-17 00:00:00 |
            | created_at           | not_null            |
            | updated_at           | null                |
            | nursery_structure_id | not_null            |

    Scenario: I can GET a child
        Given there is a child with uuid "00000000-0000-0000-0000-000000000001"
        And that child has firstname Quentin
        And that child has lastname Lemoine
        And that child has a birthday on "1993-06-17"
        And that child has a created date "2024-10-11 00:00:00"
        And that child has an updated date "2024-10-11 12:00:00"
        When I request "/api/children/00000000-0000-0000-0000-000000000001"
        Then the response code is 200
        And the response body contains JSON:
        """
        {
           "@context":"/api/contexts/Child",
           "@id":"/api/children/00000000-0000-0000-0000-000000000001",
           "@type":"Child",
           "uuid":"00000000-0000-0000-0000-000000000001",
           "id":"@variableType(integer)",
           "firstname":"Quentin",
           "lastname":"Lemoine",
           "birthday":"1993-06-17T00:00:00+00:00",
           "nurseryStructure":{
              "@type":"NurseryStructureView",
              "@id":"@variableType(string)",
              "uuid":"00000000-0000-0000-0000-000000000001",
              "id":"@variableType(integer)",
              "name":"@variableType(string)",
              "address":"@variableType(string)",
              "createdAt":"@variableType(string)",
              "opening":[
                 {
                    "@type":"NurseryStructureOpeningView",
                    "@id":"@variableType(string)",
                    "openingHour":"07:00",
                    "closingHour":"19:00",
                    "openingDay":"Monday"
                 },
                 {
                    "@type":"NurseryStructureOpeningView",
                    "@id":"@variableType(string)",
                    "openingHour":"07:00",
                    "closingHour":"19:00",
                    "openingDay":"Tuesday"
                 },
                 {
                    "@type":"NurseryStructureOpeningView",
                    "@id":"@variableType(string)",
                    "openingHour":"07:00",
                    "closingHour":"19:00",
                    "openingDay":"Wednesday"
                 },
                 {
                    "@type":"NurseryStructureOpeningView",
                    "@id":"@variableType(string)",
                    "openingHour":"07:00",
                    "closingHour":"19:00",
                    "openingDay":"Thursday"
                 },
                 {
                    "@type":"NurseryStructureOpeningView",
                    "@id":"@variableType(string)",
                    "openingHour":"07:00",
                    "closingHour":"19:00",
                    "openingDay":"Friday"
                 }
              ]
           },
           "createdAt":"2024-10-11T00:00:00+00:00",
           "updatedAt":"2024-10-11T12:00:00+00:00",
           "customers":[],
           "treatments":[]
        }
        """

    Scenario: I can put a child
        Given there is a child with uuid "00000000-0000-0000-0000-000000000001"
        And that child has firstname Quentin
        And that child has lastname Lemoine
        And that child has a birthday on "1993-06-17"
        And that child has a created date "2024-10-11 00:00:00"
        And the request body is:
        """
        {
          "firstname": "Dimebag",
          "lastname": "Darrell",
          "birthday": "2024-01-01 00:00:00",
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
           "id":"@variableType(integer)",
           "firstname":"Dimebag",
           "lastname":"Darrell",
           "birthday":"2024-01-01T00:00:00+00:00",
           "nurseryStructure":{
              "@type":"NurseryStructureView",
              "@id":"@variableType(string)",
              "uuid":"00000000-0000-0000-0000-000000000001",
              "id":"@variableType(integer)",
              "name":"@variableType(string)",
              "address":"@variableType(string)",
              "createdAt":"@variableType(string)",
              "opening":[
                 {
                    "@type":"NurseryStructureOpeningView",
                    "@id":"@variableType(string)",
                    "openingHour":"07:00",
                    "closingHour":"19:00",
                    "openingDay":"Monday"
                 },
                 {
                    "@type":"NurseryStructureOpeningView",
                    "@id":"@variableType(string)",
                    "openingHour":"07:00",
                    "closingHour":"19:00",
                    "openingDay":"Tuesday"
                 },
                 {
                    "@type":"NurseryStructureOpeningView",
                    "@id":"@variableType(string)",
                    "openingHour":"07:00",
                    "closingHour":"19:00",
                    "openingDay":"Wednesday"
                 },
                 {
                    "@type":"NurseryStructureOpeningView",
                    "@id":"@variableType(string)",
                    "openingHour":"07:00",
                    "closingHour":"19:00",
                    "openingDay":"Thursday"
                 },
                 {
                    "@type":"NurseryStructureOpeningView",
                    "@id":"@variableType(string)",
                    "openingHour":"07:00",
                    "closingHour":"19:00",
                    "openingDay":"Friday"
                 }
              ]
           },
           "createdAt":"2024-10-11T00:00:00+00:00",
           "updatedAt":"@variableType(string)",
           "customers":[],
           "treatments":[]
        }
        """
        And the table child has 1 entry with the following values:
            | uuid                 | 00000000-0000-0000-0000-000000000001 |
            | id                   | not_null                             |
            | firstname            | Dimebag                              |
            | lastname             | Darrell                              |
            | irp                  | null                                 |
            | birthday             | 2024-01-01 00:00:00                  |
            | created_at           | not_null                             |
            | updated_at           | not_null                             |
            | nursery_structure_id | not_null                             |

    Scenario: I can delete a child
        Given there is a child with uuid "00000000-0000-0000-0000-000000000001"
        And that child has firstname Quentin
        And that child has lastname Lemoine
        And that child has a birthday on "1993-06-17"
        And that child has a created date "2024-10-11 00:00:00"
        And that child has an updated date "2024-10-11 12:00:00"
        When I request "/api/children/00000000-0000-0000-0000-000000000001"
        Then the response code is 200
        When I request "/api/children/00000000-0000-0000-0000-000000000001" using HTTP DELETE
        Then the response code is 204
        When I request "/api/children/00000000-0000-0000-0000-000000000001"
        Then the response code is 404
        And the table child has no entry with the following values:
            | uuid       | 00000000-0000-0000-0000-000000000001 |