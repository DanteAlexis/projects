/**	@author Dante Alexis
  *
  *	@version 1.0
  *
  * A program that takes a sentence as input and outputs the letters(ASCII) it requires to qualify as a pangram in alphabetical order
  */

import java.util.*;

public class Part2
{
	public static void main(String[] args)
	{
		Scanner in = new Scanner(System.in);
		
		System.out.println(getMissingLetters(in.nextLine()));
	}
	
	/** Takes a sentence and returns the ASCII letters(in lowercase) it requires to qualify as a pangram.
	  *
	  *@param sentence a sentence containing an unknown amount of characters from an unknown character set
	  *
	  *@return the lowercase letters required to make the sentence a pangram
	  */
	
	public static String getMissingLetters(String sentence)
	{
		Set<Character> presentLetters = new HashSet<Character>();
		String alphabet = "abcdefghijklmnopqrstuvwxyz";
		
		for(int i = 0; i < sentence.length(); i++)
		{
			presentLetters.add(Character.toLowerCase(sentence.charAt(i)));
		}
		
		for(int j = 25; j >= 0; j--)
		{
			//If the letter is found in the set, it can be removed from the alphabet listing. Using a hashset saves on the amount of traversals/polls required
			if(presentLetters.contains(alphabet.charAt(j)))
			{
				alphabet = alphabet.substring(0,j) + alphabet.substring(j + 1);
			}
		}
		
		return alphabet;
	}
}