# Echo server program
import socket
import sys
import threading

HOST = ''                # Symbolic name meaning all available interfaces
PORT = 8888              # Arbitrary non-privileged port


print "Starting server..."

listen_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
listen_socket.bind( (HOST, PORT) )
listen_socket.listen(5)


class ListenThread ( threading.Thread ):

	def run ( self ):

		global listen_socket
		while True:
			print "Waiting for client..."
			channel, details = listen_socket.accept()
			print "Client connected."

#		print 'Received connection:', self.details [ 0 ]
#		self.channel.send ( pickledList )
#		for x in xrange ( 10 ):
#			print self.channel.recv ( 1024 )
#		self.channel.close()
#		print 'Closed connection:', self.details [ 0 ]


ListenThread().start()

#s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
#s.bind((HOST, PORT))
#s.listen(5)
#conn, addr = s.accept()
#print 'Connected by', addr
#while 1:
#    data = conn.recv(1024)
#    if not data: break
#    sys.stdout.write( data )
#    sys.stdout.flush()
#    conn.send("HELLO\n\r")
#    if data.strip() == "CLOSE":
#        break;
#conn.close()

