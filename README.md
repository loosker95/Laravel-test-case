## My list of most use assert function

### Basic

-   assertSee
-   assertSeeText - // more accurate then assertSee
-   assertDontSee
-   assertSeeInOrder([])

### --

-   assertStatus - 200 can be custumize to any http code

### Those can be use as alternative for assertStatus(xxx)

-   assertOk() - 200
-   assertSuccessful() - 2xx
-   assertCreated - 201
-   assertNoContent - 204 - can be used after delete or destroy method()
-   assertNotFound() - 404
-   assertFound() - 302
-   assertForbidden() - 403
-   assertUnauthorized() - 401
-   assertUnprocessable() - 401

### --

-   assertInstanceOf - to check if the correct data is being return

### --

-   assertDispatched - // Test Job, Event
-   assertSent - // Test Mail
-   assertSentTo - // Test notification
-   assertListening - // Test if event has attached to listener

### --

-   StringMatchesFormatTest()
-   assertStringContainsString()
-   assertStarstWith()
-   assertEndsWith()

### --

-   assertNull
-   assertNotNull

### For Api

-   assertJsonFragment() - // to check if a fragment of code exist in the response
-   assertJson
-   assertJsonStructure
-   assertJsonPath
-   assertJsonMissingPath
-   assertJsonMissing - // can be use after update and delete method

### --

-   assertModelExists
-   assertModelMissing

### For Exceptions

-   expectException()

### --

-   assertRedirect
-   assertSuccessful
-   assertSessionHasErrors
-   assertValid
-   assertInvalid
-   assertModelExists
-   assertEquals

### --

-   assertDatabaseHas
-   assertDatabaseMissing
-   assertDatabaseCount

### --

-   assertCount
-   assertViewHas
-   assertViewHasAll
-   assertTrue
-   assertJson
-   assertExactJson
-   assertSessionHas
-   assertSessionHasAll([])
