# Echo server program
import socket
import threading
import MySQLdb

HOST = ''    # Symbolic name meaning all available interfaces
PORT = 8788

EMPTY_THRESHOLD = 100


print "Starting server..."


listenSocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
listenSocket.bind( (HOST, PORT) )
listenSocket.listen(5)

clientSocket = None

db=MySQLdb.connect(host="mysql.dvanoni.com",user="whatsinmyfridge",
                  passwd="coolfront",db="whatsinmyfridge")


def shutdownClient():
	global clientSocket

	if clientSocket:
		clientSocket.shutdown(socket.SHUT_RDWR)
		clientSocket.close()



def handleMessage ( data ):
	global db

	msg = data.strip().split('\r')[0]

	if (msg == 'exit'):
		shutdownClient()
		return

	msgArray = msg.split(',')
	sensor = 3 - int(msgArray[0])
	previous = int(msgArray[1])
	current = int(msgArray[2])

	# Check for removed item
	if (current < EMPTY_THRESHOLD):
		db.query("DELETE FROM items WHERE sensor=%d" % sensor)
	else:
		db.query("SELECT * FROM items WHERE sensor=%d" % sensor)
		result = db.store_result()
		if (result.num_rows() == 0):
			#prevVal = result.fetch_row(how=1)[0]['val']
			db.query("INSERT INTO items (sensor, val) VALUES (%d, %d) ON DUPLICATE KEY UPDATE val=%d" % (sensor, current, current))



class ListenThread ( threading.Thread ):

	def run ( self ):

		global listenSocket
		global clientSocket

		while True:
			print "Waiting for client..."
			try:
				clientSocket, details = listenSocket.accept()
				if not clientSocket:
					break
			except:
				break
			else:
				print "Client connected."

				while True:
					print "Waiting to receive..."
					try:
						data = clientSocket.recv(1024)
						if not data:
							break
					except:
						break
					else:
						print data
						handleMessage(data)

				print "Client disconnected."

		print "Listening stopped."



listener = ListenThread()
listener.start()


print "Type 'q' to quit"

input = ''
while (input != 'q'):
	input = raw_input()

print "Shutting down..."

listenSocket.shutdown(socket.SHUT_RDWR)
listenSocket.close()

try:
	clientSocket.shutdown(socket.SHUT_RDWR)
except:
	pass
else:
	clientSocket.close()


while listener.isAlive():
	listener.join()

print "Done."

