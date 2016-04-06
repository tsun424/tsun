DELIMITER //
CREATE PROCEDURE P_CHK_ACTIVITY
(OUT O_RESULT INT(1))
BEGIN

	/* TODO find overdue activities and insert into notification table
	DECLARE C_ACTIVITY CURSOR FOR SELECT ID FROM ACTIVITIES WHERE STATUS = 10 AND START_TIME < now() AND END_TIME < now();
	DECLARE EXIT HANDLER FOR SQLWARNING,NOT FOUND,SQLEXCEPTION SET O_RESULT = -1;
    
	OPEN C_ACTIVITY;
    LOOP 
		FETCH C_ACTIVITY INTO ID;
        
    END LOOP;
    
    CLOSE C_ACTIVITY;
    */
    SET O_RESULT = -1;
    
    UPDATE ACTIVITIES SET STATUS = 12 
    WHERE STATUS = 10 AND START_TIME < now() AND END_TIME < now();
    
    UPDATE ACTIVITIES SET STATUS = 10 
    WHERE STATUS = 12 AND START_TIME < now() AND END_TIME > now();
    
    SET O_RESULT = 1;
END;