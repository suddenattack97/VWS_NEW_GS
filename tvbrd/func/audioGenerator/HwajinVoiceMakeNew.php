����   2 �
 + C	 ( D E
  C	 ( F	 ( G	 ( H	 ( I	 ( J
  K
 L M
  N	 O P Q
  C R
  S
  T
  U V
  W
 X Y Z [	  \ ]	  ^
 ( _ ` a b
  c d
 ! e
 ! f
 ! g h
 L i
 L j k
 ( C
 ( l m nReturn I ttsapi Lvoiceware/libttsapi; host Ljava/lang/String; port szText filepathnamne <init> ()V Code LineNumberTable VoiceTextBuffer L(Ljava/lang/String;Ljava/lang/Integer;Ljava/lang/String;Ljava/lang/String;)V StackMapTable Z writeByteToFile (Ljava/lang/String;[BI)V main ([Ljava/lang/String;)V 
SourceFile HwajinVoiceMakeNew.java 5 6 , - voiceware/libttsapi . / 0 1 2 1 3 1 4 1 n o p q r s t u v w java/lang/StringBuilder Current connect timeout =  x y z r x { (msec) | } ~  � java/io/IOException RequestBuffer Success (length= � - )!! 성공  � � = > Failed ( )!!! java/io/File 5 � java/io/FileOutputStream 5 � � � � 6 file write error!!! � � � � HwajinVoiceMakeNew 9 : java/lang/Object SetConnectTimeout (I)V java/lang/Integer intValue ()I ttsRequestBuffer ,(Ljava/lang/String;ILjava/lang/String;IIII)I java/lang/System out Ljava/io/PrintStream; append -(Ljava/lang/String;)Ljava/lang/StringBuilder; GetConnectTimeout (I)Ljava/lang/StringBuilder; toString ()Ljava/lang/String; java/io/PrintStream println (Ljava/lang/String;)V nVoiceLength szVoiceData [B (Ljava/io/File;)V write ([BII)V close parseInt (Ljava/lang/String;)I valueOf (I)Ljava/lang/Integer; ! ( +      , -     . /     0 1     2 1     3 1     4 1     5 6  7   Y     )*� *� *� Y� � *� *� *� *� 	�    8          	   
     #   9 :  7   	    �*� �� 
**� +,� -
� � � � Y� � *� � � � � � � :*�� *� � >� � Y� � *� � � � � � **� � *� � � � $� � Y� � *� � � � � �    D G   8   .     
     D  G  I  O  W  {  �  �   ;    � G <� B   = >  7   y     0� Y+�  :� !Y� ":,� #� $� :� %� �    " %   8   "    ) 
 *  +  , " / % - ' . / 0 ;    e <	 	 ? @  7   [     +*2L*2� &� 'M*2N*2:� (Y� ):+,-� *�    8       H  I  J  K  M   O * Q  A    B