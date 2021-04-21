# WAMP_Web


## Database
MYSQL 
---
Table 1 : 
Room     
-RoomID Host inv_code maximum_player status[created/canceled/started/finished] current_question list_of_player

User
-UserID username created_dt 

Question
-QuestionID question choice1 choice2 choice3 choice4 correct_choice RoomID question_no

---

## Backend 
PHP 
---
### Function
1. Create User (Post)
req: username  
response : success / failed , userid  

2. Create Gameroom (Post)
req : host_id maximum_player question_array   
logic : create room -> unpack question_array , store in question table , current_question=0   
response : inv_code,Room_id  

3. join gameroom (Post)
req : user_id , inv_code   
logic : append user_id to list_of_player   
res : success/failed ( with reason max players/wrong inv_code) ,  roomID   

4. Start gameroom(post)
req : Userid / Roomid   
logic : change status to started , current_question=1   
res : success/ failed  

5. Get Room Status(post)   
req : Roomid  
res : success/failed, status / current_question   

6. Get question (post)  
req: RoomID , current_question  
res : success/ failed, question , choices 1-4 ,correct_choice  

7. change question_no(post)  
req: UserID ,RoomID , to_question  
res : success/failed   

8. End Gameroom(Post)  
req: UserID, RoomID    
logic : status -> finished  

---
FrontEnd 

TODO

